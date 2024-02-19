<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {
            $is_admin = Auth()->user()->is_admin;

            if($is_admin==false)
            {
                $userId = auth()->user()->id;
                $memberCount = User::where('is_admin', false)->count();
                $contCount = Contribution::where('member_id', $userId)->count();
                $members = User::where('is_admin', false)->orderBy('created_at', 'desc')->take(5)->get();
                return view('member.dashboard', compact('members','memberCount','contCount'));
            }
            else if($is_admin==true)
            {
                $balance = Contribution::sum('amount');
                $memberCount = User::where('is_admin', false)->count();
                $contCount = Contribution::count();
                $members = User::where('is_admin', false)->orderBy('created_at', 'desc')->take(5)->get();
                $cont = Contribution::take(5)->get();
                return view('admin.dashboard', compact('members','cont','memberCount','contCount', 'balance'));
            }
            else{
                return redirect()->back();
            }
        }
    }

    
}
