<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', [
            'user' => auth()->user()
        ]);
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
        ]);

        $request->user()->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Profil mis à jour avec succès');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->user()->avatar) {
            Storage::delete($request->user()->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $request->user()->update(['avatar' => $path]);

        return back()->with('success', 'Photo de profil mise à jour avec succès');
    }

}
