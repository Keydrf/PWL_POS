<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return UserModel::with('level')->get();
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'level_id' => 'required|exists:m_levels,level_id',
            'username' => 'required|string|max:20|unique:m_users,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = UserModel::create($validated);
        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = UserModel::with('level')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = UserModel::findOrFail($id);

        $validated = $request->validate([
            'level_id' => 'sometimes|exists:m_levels,level_id',
            'username' => 'sometimes|string|max:20|unique:m_users,username,' . $id . ',user_id',
            'nama' => 'sometimes|string|max:100',
            'password' => 'nullable|string|min:6',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus.',
        ]);
    }
}

