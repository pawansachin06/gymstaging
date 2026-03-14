<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function show(Request $request, $slug)
    {
        if (str_contains($slug, '_')) {
            return redirect()->to(str_replace('_', '-', $request->path()), 301);
        }
        $slug = strtoupper(str_replace('-', '_', $slug));
        $item = Setting::query()->select('value')
            ->where('name', $slug)->first(['value']);
        if (!$item) {
            abort(404);
        }
        return view('settings.page', ['item' => $item]);
    }
}
