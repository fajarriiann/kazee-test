<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function create(): View
    {
        return view('user.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        $user->userDetail()->create([
            'user_id'       => $user->id,
            'date_of_birth' => $request->date_of_birth,
            'phone_number'  =>  $request->phone_number,
            'address'       =>  $request->address
        ]);
        
        return Redirect::route('user.create')->with('status', 'user-created');
    }

    public function edit(string $id): View
    {
        $user = User::where('id', $id)
        ->first();

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        if ($request->filled('password')) {
            $request->validate([
                'name'      => ['required', 'string', 'max:255'],
                'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$id.''],
                'password'  => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user                               = User::findOrFail($id);
            $user->name                         = $request->name;
            $user->email                        = $request->email;
            $user->password                     = Hash::make($request->password);
            $user->userDetail->date_of_birth    = $request->date_of_birth;
            $user->userDetail->phone_number     = $request->phone_number;
            $user->userDetail->address          = $request->address;
            $user->push();
        } else {
            $request->validate([
                'name'      => ['required', 'string', 'max:255'],
                'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$id.''],
            ]);

            $user                               = User::findOrFail($id);
            $user->name                         = $request->name;
            $user->email                        = $request->email;
            $user->userDetail->date_of_birth    = $request->date_of_birth;
            $user->userDetail->phone_number     = $request->phone_number;
            $user->userDetail->address          = $request->address;
            $user->push();
        }

        return Redirect::route('user.edit', $id)->with('status', 'user-updated');
    }

    public function destroy(string $id): RedirectResponse
    {
        User::find($id)
        ->delete();

        return Redirect::back();
    }
}
