<?php

namespace App\Http\Controllers\member;

use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    public function index()

    {
        $userId = auth()->user()->id;
        $contributions = Contribution::where('member_id', $userId)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('member.contributions.index', compact('contributions'));
    }

    public function create()
    {
        return view('member.contributions.create');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'amount' => 'required|numeric',
            'method' => 'required|in:ecocash,bank-transfer,cash',
            'verification_code' => 'required|string',
        ]);

        // Create a new Contribution model and save the data
        Contribution::create([
            'amount' => $request->input('amount'),
            'method' => $request->input('method'),
            'verification_code' => $request->input('verification_code'),
            'member_id' => auth()->id(), // Get the authenticated user's ID
        ]);

        // Redirect back with a success message or do any other action
        return redirect()->route('member.contribution')->with('success', 'Contribution successfully added.');
    }
}
