<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

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
            return response()->json(['message' => $e->getMessage()], 500);
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
        return view('services.admin.edit', ['item'=> $service]);
    }

    public function update(Request $request, Service $service)
    {
        //
    }

    public function destroy(Service $service)
    {
        //
    }
}
