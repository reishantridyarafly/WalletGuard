<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function settingsProfile(Request $request)
    {
        $id = auth()->user()->id;
        $validated = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email,' . $id,
                'photo' => 'image|mimes:jpg,png,jpeg,webp,svg|file|max:5120',
                'phone_number' => 'required|unique:users,phone_number,' . $id,
            ],
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                if ($file->isValid()) {
                    $randomFileName = uniqid() . '.' . $file->getClientOriginalExtension();
                    $request->file('photo')->storeAs('avatar/', $randomFileName, 'public');

                    $user = User::findOrFail($id);

                    if (Storage::exists('public/avatar/' . $user->avatar)) {
                        Storage::delete('public/avatar/' . $user->avatar);
                    }

                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->phone_number = $request->phone_number;
                    $user->avatar = $randomFileName;
                    $user->save();

                    return response()->json(['success' => 'Data saved successfully']);
                }
            } else {
                $user = User::findOrFail($id);

                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone_number = $request->phone_number;
                $user->save();

                return response()->json(['success' => 'Data saved successfully']);
            }
        }
    }

    public function deletePhoto()
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);

        if (!empty($user->avatar)) {
            if (Storage::exists('public/avatar/' . $user->avatar)) {
                Storage::delete('public/avatar/' . $user->avatar);
            }

            $user->avatar = null;
            $user->save();

            return response()->json(['success' => "Photo successfully deleted", 'name' => $user->name]);
        } else {
            return response()->json(['success' => false, 'error' => 'Photo not found.']);
        }
    }

    public function changePassword(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'old_password' => 'required',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
            ],
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                return response()->json(['error_password' => 'Old password is wrong!']);
            } else {
                User::whereId(auth()->user()->id)->update([
                    'password' => Hash::make($request->password)
                ]);
                return response()->json(['success' => 'Password changed successfully']);
            }
        }
    }

    public function deleteAccount(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'password' => 'required|string|min:8',
            ],
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $user = auth()->user();

            if (!Hash::check($request->password, $user->password)) {
                return response()->json(['errors' => ['password' => 'Incorrect password. Please try again.']]);
            } else {
                User::whereId(auth()->user()->id)->update([
                    'active_status' => '1'
                ]);

                return response()->json(['success' => true]);
            }
        }
    }
}
