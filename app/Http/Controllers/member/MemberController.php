<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        

        $members = User::where('is_admin', false)->paginate(10); // Adjust the pagination size as needed
        return view('member.members.index', compact('members'));
    }
    public function search(Request $request)
    {
        $search = $request->search;
        $members = User::where(function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orwhere('email', 'like', "%$search%");
        })
            ->where('is_admin', false)
            ->get();

        return view('member.members.search', compact('members', 'search'));
    }
}
