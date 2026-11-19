<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username' => 'required|string|unique:tb_user,username',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,petugas,owner',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status_aktif' => 1,
        ]);

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Menambahkan user ' . $request->username,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username' => 'required|string|unique:tb_user,username,' . $user->id_user . ',id_user',
            'role' => 'required|in:admin,petugas,owner',
            'status_aktif' => 'required|boolean',
        ]);

        $data = $request->only('nama_lengkap', 'username', 'role', 'status_aktif');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Mengedit user ' . $user->username,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $username = $user->username;

        $user->delete();

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Menghapus user ' . $username,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}