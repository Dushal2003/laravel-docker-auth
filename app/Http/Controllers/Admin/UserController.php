<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $sort   = $request->query('sort', 'desc');

        $usersQuery = User::query();

        if ($search) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $usersQuery
            ->orderBy('id', $sort)
            ->paginate(10)
            ->appends($request->only('q', 'sort'));

        return view('admin.users.index', compact('users', 'search', 'sort'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|min:3',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:6|confirmed',
            'user_type' => 'required|in:user,admin',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_verified'] = true;

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'      => 'required|string|min:3',
            'email'     => "required|email|unique:users,email,{$user->id}",
            'password'  => 'nullable|string|min:6|confirmed',
            'user_type' => 'required|in:user,admin',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted');
    }
}
