<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Read: Ipakita ang tanang users ug ilang roles[cite: 2, 3]
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Create: Ipakita ang form sa paghimo og user[cite: 2, 3]
    public function create()
    {
        return view('users.create');
    }

    // Store: I-save ang bag-ong user sa database[cite: 2, 3]
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:Administrator,Student,Faculty / Staff', // Gi-limite sa proposal roles[cite: 1, 2, 3]
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User successfully created!');
    }

    // Edit: Ipakita ang form para sa pag-usab sa user[cite: 2, 3]
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update: I-save ang gi-usab nga impormasyon[cite: 2, 3]
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:Administrator,Student,Faculty / Staff',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User successfully updated!');
    }

    // Delete: Pagtangtang sa user sa sistema[cite: 2, 3]
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User successfully deleted!');
    }
}