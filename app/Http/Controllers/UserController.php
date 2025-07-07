<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('backend.users.index', compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/users'), $imageName);
        }

        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->image    = $imageName;
        $user->status   = $request->has('status') ? 'on' : 'off'; // handles checkbox
        $user->created_by = Auth::user()->id ; // optional: tracks creator
        $user->save();

        return redirect()->route('user.index')->with('success', 'User created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate the incoming data
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
        ];

        // If password is provided, validate it
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|max:255|confirmed';
        }

        $request->validate($rules);

        // Handle image upload
        $imageName = $user->image; // default to old image
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/users'), $imageName);
        }

        // Update user fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $user->status = $request->has('status') ? 'on' : 'off'; // checkbox fallback

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);
        $user = User::findOrfail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User Deleted!');
    }

    public function Status($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'on' ? 'off' : 'on';
        $user->save();

        return redirect()->back()->with('success', 'User Status Updated!');
    }
}
