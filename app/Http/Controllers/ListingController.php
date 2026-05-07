<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingReview;
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
        if (!$listing) {
            abort(500, 'Listing not found');
        }
        if ($request->boolean('ajax')) {
            $completedSteps = [];
            if (!empty($listing->profile_image) && !empty($listing->cover_image)) {
                $completedSteps[] = 'profile-and-cover-photo';
            }
            if ($listing->created_at != $listing->updated_at) {
                $completedSteps[] = 'tagging-permissions';
            }
            return resJson([
                'item' => $listing,
                'completed_steps' => $completedSteps,
            ]);
        }
        $serviceVariant = $request->input('service-variant', 'coach');
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
            foreach ($oldFiles as $oldFile) {
                Storage::disk('uploads')->delete($oldFile);
            }
            return resJson('Saved successfully');
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
