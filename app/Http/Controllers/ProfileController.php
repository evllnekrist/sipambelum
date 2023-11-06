<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Option;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit($id): View
    {
        $data['user'] = User::find($id);
        $data['roles'] = Option::where('type', 'ROLE')->orderBy('id','DESC')->get();
        $data['pp_ids'] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        return view('profile.edit', $data);
    }

    /**
     * Update the user's profile information.
     */
    public function update($id, Request $request): RedirectResponse // ProfileUpdateRequest $request
    {
        $request->validate([
            'role' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. $id],
        ]);

        $user = User::find($id);
        $user->role = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->img_profile_id = $request->pp;
        $user->save();

        // org ------ start
        // $request->user()->fill($request->validated());
        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }
        // $request->user()->save();
        // org ------ end

        return Redirect::route('profile.edit', $id)->with('status', 'Profil berhasil diupdate')->with('status_type',true); //profile-updated
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
