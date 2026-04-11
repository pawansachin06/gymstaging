<?php

namespace App\Http\Controllers;

use App\Enums\ServiceVariantEnum;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        //
    }

    public function adminIndex(Request $request)
    {
        $keyword = $request->query('q', '');
        $limit = (int) $request->input('limit', 25);
        $query = Service::query();
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                    ->orWhere('id', 'like', "%$keyword%");
            });
        }
        $paginator = $query->orderBy('id', 'desc')
            ->paginate($limit)->withQueryString();
        return view('services.admin.index', [
            'items' => $paginator,
            'keyword' => $keyword,
            'page' => $paginator->currentPage(),
            'last' => $paginator->lastPage(),
            'limit' => $paginator->perPage(),
            'total' => $paginator->total(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function adminStore(Request $request)
    {
        try {
            $item = Service::create([
                'label' => '',
                'name' => 'New service',
                'type' => 'professional',
                'slug' => date('Y-m-d-h-i-s'),
            ]);
            $redirect = route('admin.services.edit', $item);
            return response()->json([
                'redirect' => $redirect,
                'message' => 'Loading...'
            ]);
        } catch (Exception $e) {
            return resJson($e->getMessage(), 500);
        }
    }

    public function show(Service $service)
    {
        //
    }

    public function edit(Service $service)
    {
        //
    }

    public function adminEdit(Request $request, Service $service)
    {
        $variants = ServiceVariantEnum::labels();
        return view('services.admin.edit', [
            'item'=> $service,
            'variants' => $variants,
        ]);
    }

    public function update(Request $request, Service $service){
        
    }

    public function adminUpdate(Request $request, Service $service)
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'variant' => ['required', Rule::enum(ServiceVariantEnum::class)],
            'label' => ['nullable', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', Rule::unique(Service::class, 'slug')->ignore($service->id)],
            'parent_id' => ['nullable', Rule::exists(Service::class, 'id')],
            'type' => ['required', 'in:professional,organization'],
        ]);
        try {
            $input['label'] = empty($input['label']) ? $input['name'] : $input['label'];
            $service->update($input);
            return resJson('Updated successfully');
        } catch (Exception $e) {
            return resJson($e->getMessage(), 500, $e);
        }
    }

    public function destroy(Service $service)
    {
        //
    }
}
