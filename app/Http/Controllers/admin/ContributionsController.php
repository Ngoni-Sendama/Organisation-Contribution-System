<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use Illuminate\Http\Request;

class ContributionsController extends Controller
{
    public function index()
    {
        $contributions = Contribution::paginate(10);
        return view('admin.contributions.index', compact('contributions'));
    }
}
