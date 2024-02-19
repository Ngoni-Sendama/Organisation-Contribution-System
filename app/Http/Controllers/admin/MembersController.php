<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MembersController extends Controller
{
    public function index()
    {
        $members = User::where('is_admin', false)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.members.index', compact('members'));
    }
    public function show($id)
    {
        $member = User::findorfail($id);
        return view('admin.members.show', compact('member'));
    }
    public function deleteUser(Request $request, $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('admin.members')->with('error', 'User not found.');
        }

        // Check if the user being deleted is not the currently logged-in admin
        if ($user->id === auth()->user()->id) {
            return redirect()->route('admin.members')->with('error', 'Cannot delete the currently logged-in admin.');
        }

        $user->delete();

        return redirect()->route('admin.members')->with('success', 'User deleted successfully.');
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

        return view('admin.members.show', compact('members', 'search'));
    }
}
