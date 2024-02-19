<?php

namespace App\Http\Controllers\admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;


class AdminController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }
    public function clearCache()
    {
        Artisan::call('cache:clear');

        return redirect()->back()->with('success', 'Cache cleared successfully.');
    }
}
