<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingTeam;
use App\Models\ListingReview;
use App\Models\ListingQualification;
use App\Models\Service;
use App\Http\Requests\UpdateListingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class ListingController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, string $countryCode, Service $service, Listing $listing)
    {
        $perPage = max(1, (int) $request->query('per-page', 5));
        $isAjax = $request->boolean('ajax');
        $model = $request->input('model');
        if ($isAjax) {
            if ($model === 'listing-review') {
                $paginator = ListingReview::query()->where('listing_id', $listing->id)
                    ->paginate($perPage, ['id', 'rating', 'message', 'user_name', 'created_at']);
                $reviews = collect($paginator->items())->map(function($item) {
                    $item->created_at_label = $item->created_at->diffForHumans();
                    return $item;
                });
                return resJson([
                    'page' => $paginator->currentPage(),
                    'last' => $paginator->lastPage(),
                    'limit' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'items' => $reviews,
                ]);
            }
        }

        $mapId = config('services.google.maps.id');
        $listingLinks = $listing->links ?? [];
        $address = $listing->address;
        $media = $listing->media;
        return view('listings.show', [
            'mapId' => $mapId,
            'media' => $media,
            'item' => $listing,
            'address' => $address,
            'listingLinks' => $listingLinks,
            'markerUrl' => $listing->marker_image_url,
        ]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        $listing = $user->listing;
        $keyword = $request->input('q');
        $action = $request->input('action');
        if (!$listing) {
            abort(500, 'Listing not found');
        }
        if ($request->boolean('ajax')) {
            if (in_array($action, ['mentions', 'teams'])) {
                $mentionsQuery = Listing::query()
                    ->with('service:id,slug,name')
                    ->where('taggable', 1)->where('published', 1)
                    ->whereNot('id', $listing->id)->limit(5);
                if (!empty($keyword)) {
                    $mentionsQuery->where(function ($q) use ($keyword) {
                        $q->where('name', 'like', "%$keyword%")
                            ->orWhere('title', 'like', "%$keyword%");
                    });
                }
                $items = $mentionsQuery->get([
                    'id', 'name', 'slug', 'folder', 'profile_image',
                    'country_code', 'service_id'
                ]);
                return resJson(['items' => $items]);
            }

            $completedSteps = [];
            if (!empty($listing->profile_image) && !empty($listing->cover_image)) {
                $completedSteps[] = 'profile-and-cover-photo';
            }
            if ($listing->created_at != $listing->updated_at) {
                $completedSteps[] = 'tagging-permissions';
            }
            $mentions = [];
            if (!empty($listing->mentions)) {
                $ids = array_column($listing->mentions, 'id');
                $mentions = Listing::query()
                    ->with('service:id,slug,name')
                    ->where('taggable', 1)
                    ->where('published', 1)
                    ->whereIn('id', $ids)
                    ->get([
                        'id', 'name', 'slug', 'folder', 'profile_image',
                        'country_code', 'service_id',
                    ]);
            }
            $teams = $listing->teams()->with('listing:id,name,folder,profile_image')->get();
            $qualifications = $listing->qualifications()->with('listing:id,folder')->get();
            // foreach ($teams as $team) {
            //     $team->folder = $listing->folder;
            // }
            $conversionTypes = Listing::getConversionTypes();
            $listing->append(['timetable_url']);
            return resJson([
                'teams' => $teams,
                'item' => $listing,
                'mentions' => $mentions,
                'qualifications' => $qualifications,
                'completed_steps' => $completedSteps,
                'conversion_types' => $conversionTypes,
            ]);
        }
        $listing->load('service:id,slug,type,variant');
        $serviceVariant = $listing->service ? $listing->service->variant->value : 'coach';
        $listing->service_type = $listing->service ? $listing->service->type : '';
        $listing->service_slug = $listing->service ? $listing->service->slug : '';
        return view('listings.edit', [
            'item' => $listing,
            'serviceVariant' => $serviceVariant,
        ]);
    }

    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $input = $request->validated();
        $oldFiles = [];
        $updates = [];
        DB::beginTransaction();
        try {
            $listing->update($input);
            $folder = $listing->folder;

            if ($request->hasFile('profile_image_file')) {
                $image = $request->file('profile_image_file');
                $filename = site()->generateFilename($image, "{$listing->id}-profile");
                site()->saveImage($image, $folder, $filename, 100, 100);
                if (!empty($listing->profile_image)) {
                    $oldFiles[] = "{$folder}/{$listing->profile_image}";
                }
                $updates['profile_image'] = $filename;
            }
            if ($request->hasFile('cover_image_file')) {
                $image = $request->file('cover_image_file');
                $filename = site()->generateFilename($image, "{$listing->id}-cover");
                site()->saveImage($image, $folder, $filename, 720, 360);
                if (!empty($listing->cover_image)) {
                    $oldFiles[] = "{$folder}/{$listing->cover_image}";
                }
                $updates['cover_image'] = $filename;
            }
            if ($request->hasFile('timetable')) {
                $timetable = $request->file('timetable');
                $filename = site()->generateFilename($timetable, "{$listing->id}-timetable");
                Storage::disk('uploads')->putFileAs($folder, $timetable, $filename);
                $updates['timetable'] = $filename;
                if (!empty($listing->timetable)) {
                    $oldFiles[] = "{$folder}/{$listing->timetable}";
                }
            } elseif ($request->boolean('remove_timetable')) {
                if (!empty($listing->timetable)) {
                    $oldFiles[] = "{$folder}/{$listing->timetable}";
                }
                $updates['timetable'] = null;
            }

            $mediaFiles = collect($listing->media_files ?? []);
            $transformationFiles = collect($listing->transformation_files ?? []);
            
            $mediaDeletes = json_decode($request->input('media_file_deletes', '[]'), true);
            $transformationDeletes = json_decode($request->input('transformation_file_deletes', '[]'), true);

            $deletedMedia = $mediaFiles->whereIn('id', $mediaDeletes);
            foreach ($deletedMedia as $file) {
                $oldFiles[] = "{$folder}/{$file['name']}";
            }
            $mediaFiles = $mediaFiles->whereNotIn('id', $mediaDeletes)->values();

            $deletedTransformations = $transformationFiles->whereIn('id', $transformationDeletes);
            foreach ($deletedTransformations as $file) {
                $oldFiles[] = "{$folder}/{$file['name']}";
            }
            $transformationFiles = $transformationFiles->whereNotIn('id', $transformationDeletes)->values();

            if ($request->hasFile('media_file')) {
                foreach ($request->file('media_file') as $file) {
                    $filename = site()->generateFilename(
                        $file, "{$listing->id}-media"
                    );
                    Storage::disk('uploads')->putFileAs($folder, $file, $filename);
                    $mediaFiles->push([
                        'id' => (string) Str::uuid(),
                        'name' => $filename,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
                $updates['media_files'] = $mediaFiles;
            }
            if ($request->hasFile('transformation_file')) {
                foreach ($request->file('transformation_file') as $file) {
                    $filename = site()->generateFilename(
                        $file, "{$listing->id}-transformation"
                    );
                    Storage::disk('uploads')->putFileAs($folder, $file, $filename);
                    $transformationFiles->push([
                        'id' => (string) Str::uuid(),
                        'name' => $filename,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
                $updates['transformation_files'] = $transformationFiles;
            }
            $updates['media_files'] = $mediaFiles->values()->toArray();
            $updates['transformation_files'] = $transformationFiles->values()->toArray();
            $listing->update($updates);
            DB::commit();

            // teams start
            $existingTeamIds = [];
            $teams = $request->teams ?? [];
            foreach ($teams as $index => $teamData) {
                $team = null;
                // existing team
                if (!empty($teamData['id']) && is_numeric($teamData['id'])) {
                    $team = ListingTeam::query()->where('listing_id', $listing->id)->find($teamData['id']);
                }
                // new team
                if (!$team) {
                    $team = new ListingTeam();
                    $team->listing_id = $listing->id;
                    $team->user_id = $listing->user_id;
                }
                $team->job = $teamData['job'];
                $team->name = $teamData['name'];
                // upload file
                if ($request->hasFile("team_files.$index")) {
                    // delete old
                    if ($team->file_path) {
                        $path = "{$folder}/{$team->file_path}";
                        Storage::disk('uploads')->delete($path);
                    }
                    $file = $request->file("team_files.$index");
                    $filename = site()->generateFilename($file, "{$listing->id}-team");
                    Storage::disk('uploads')->putFileAs($folder, $file, $filename);
                    $team->file_path = $filename;
                }
                $team->save();
                $existingTeamIds[] = $team->id;
            }
            
            $removedTeams = ListingTeam::query()
                ->where('listing_id', $listing->id)
                ->whereNotIn('id', $existingTeamIds)
                ->get();
            foreach ($removedTeams as $team) {
                if ($team->file_path) {
                    $path = "{$folder}/{$team->file_path}";
                    Storage::disk('uploads')->delete($path);
                }
                $team->delete();
            }
            // teams end

            // qualifications start
            $qualifications = $request->qualifications ?? [];
            $savedQualificationIds = [];
            foreach ($qualifications as $index => $item) {
                $qualification = null;
                // existing
                if (!empty($item['id']) && is_numeric($item['id'])) {
                    $qualification = ListingQualification::query()
                        ->where('listing_id', $listing->id)
                        ->find($item['id']);
                }
                // new
                if (!$qualification) {
                    $qualification = new ListingQualification();
                    $qualification->listing_id = $listing->id;
                    $qualification->status = 'pending';
                }
                $qualification->name = $item['name'];
                // upload
                if ($request->hasFile("qualification_files.$index")) {
                    // delete old
                    if ($qualification->file) {
                        $path = "{$folder}/{$qualification->file}";
                        Storage::disk('uploads')->delete($path);
                    }
                    $file = $request->file("qualification_files.$index");
                    $filename = site()->generateFilename($file, "{$listing->id}-qualification");
                    Storage::disk('uploads')->putFileAs($folder, $file, $filename);
                    $qualification->file = $filename;
                }
                $qualification->save();
                $savedQualificationIds[] = $qualification->id;
            }
            $deletedItems = ListingQualification::query()
                ->where('listing_id', $listing->id)
                ->whereNotIn('id', $savedQualificationIds)
                ->get();
            foreach ($deletedItems as $item) {
                if ($item->file) {
                    $path = "{$folder}/{$item->file}";
                    Storage::disk('uploads')->delete($path);
                }
                $item->delete();
            }
            // qualifications end

            foreach ($oldFiles as $oldFile) {
                Storage::disk('uploads')->delete($oldFile);
            }
            $teams = $listing->teams()->with('listing:id,name,folder,profile_image')->get();
            $qualifications = $listing->qualifications()->with('listing:id,folder')->get();
            return resJson([
                'teams' => $teams,
                'qualifications' => $qualifications,
                'message' => 'Saved successfully'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return resJson($e->getMessage(), 500, $e);
        }
    }

    public function verify()
    {
        return view('listings.verify', []);
    }

    public function destroy(Listing $listing)
    {
        //
    }
}
