<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CurrencyController extends Controller
{
    public function index()
    {
        //
    }

    public function adminIndex(Request $request)
    {
        $keyword = $request->query('q', '');
        $limit = (int) $request->input('limit', 25);
        $trashed = !empty($request->query('trashed'));
        $query = Currency::query();
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                    ->orWhere('id', 'like', "%$keyword%");
            });
        }
        if (!empty($trashed)) {
            $query->onlyTrashed();
        }
        $paginator = $query->orderBy('id', 'desc')
            ->paginate($limit)->withQueryString();
        return view('currencies.admin.index', [
            'items' => $paginator,
            'keyword' => $keyword,
            'trashed' => $trashed,
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

    public function store(StoreCurrencyRequest $request)
    {
        //
    }

    public function adminStore(Request $request)
    {
        try {
            $code = strtoupper(Str::random(3));
            $exists = Currency::query()->where('code', $code)->first(['id']);
            if ($exists) {
                return resJson('Connection broke, try again', 422);
            }
            $item = Currency::create([
                'name' => 'New Currency',
                'rate' => 1,
                'sequence' => 1,
                'code' => $code,
                'default' => false,
            ]);
            $redirect = route('admin.currencies.edit', $item);
            return response()->json([
                'redirect' => $redirect,
                'message' => 'Loading...'
            ]);
        } catch (Exception $e) {
            return resJson($e->getMessage(), 500, $e);
        }
    }

    public function show(Currency $currency)
    {
        //
    }

    public function edit(Currency $currency)
    {
        //
    }

    public function adminEdit(Currency $currency)
    {
        return view('currencies.admin.edit', [
            'item' => $currency,
        ]);
    }

    public function update(UpdateCurrencyRequest $request, Currency $currency)
    {
        //
    }

    public function adminUpdate(Request $request, Currency $currency)
    {
        $request->merge(['code' => Str::upper($request->input('code', ''))]);
        $input = $request->validate([
            'name' => ['required', 'string', 'max:32'],
            'code' => ['required', 'string', 'max:3', Rule::unique(Currency::class, 'code')->ignore($currency->id)],
            'rate' => ['required', 'numeric', 'decimal:0,2'],
            'sequence' => ['required', 'numeric', 'integer', 'gte:0'],
        ]);
        try {
            $currency->update($input);
            return resJson('Updated successfully');
        } catch (Exception $e) {
            return resJson($e->getMessage(), 500, $e);
        }
    }

    public function adminRestore(Request $request, string $id)
    {
        $item = Currency::query()->withTrashed()->findOrFail($id);
        try {
            $item->restore();
            $name = $item->name;
            return resJson("Restored $name");
        } catch (Exception $e) {
            return resJson($e->getMessage(), 500, $e);
        }
    }
    
    public function adminDelete(Request $request, string $id)
    {
        $permanent = $request->input('permanent');
        try {
            $item = Currency::query()->withTrashed()->findOrFail($id);
            if ($item->default) {
                return resJson('Cannot delete default currency', 422);
            }
            if (empty($permanent)) {
                $item->delete();
                return resJson("Trashed {$item->name}, refresh page to view changes");
            }
            $item->forceDelete();
            return resJson("Deleted {$item->name}");
        } catch (Exception $e) {
            return resJson($e->getMessage(), 500, $e);
        }
    }

    public function destroy(Currency $currency)
    {
        //
    }
}
