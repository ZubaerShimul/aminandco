<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequeset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = User::where(['id' => Auth::id()])->first();
        if (empty($user)) {
            return redirect()->back()->with('dismiss', __("You have no access rights"));
        }
        return view('user.profile', ['user' => $user]);
    }

    public function profileUpdate(ProfileUpdateRequeset $request)
    {
        $user = User::where(['id' => Auth::id()])->first();
        if (empty($user)) {
            return redirect()->back()->with('dismiss', __("You have no access rights"));
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('profile')->with('success', __("Profile Successfully updated"));
    }

    /**
     * password Update
     */

     public function password()
    {
        return view('user.password');
    }

     public function passwordUpdate(PasswordUpdateRequest $request)
     {
         $user = User::where(['id' => Auth::id()])->first();
         if (empty($user)) {
             return redirect()->back()->with('dismiss', __("You have no access rights"));
         }
         $user->update([
             'password' => Hash::make($request->password)
         ]);
 
         return redirect()->route('admin.dashboard')->with('success', __("Password Successfully updated"));
     }
}
