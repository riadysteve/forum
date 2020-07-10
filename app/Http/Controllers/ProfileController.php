<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($user) {
        $user = User::findOrFail($user);

        return view('profile.index', compact('user'));
    }

    public function edit($user) {
        $user = User::findOrFail($user);
        $this->authorize('update', $user->profile);

        return view('profile.edit', compact('user'));
    }

    public function update(User $user, Request $request) {
        $this->authorize('update', $user->profile);

        $this->validate($request, [
            'url' => 'url'
        ]);
        
        auth()->user()->profile->update([
            'description' => $request->description,
            'url' => $request->url
        ]);

        return redirect()->route('profile.index', $user->id)->with('success', 'Your Profile Updated');
    }
}