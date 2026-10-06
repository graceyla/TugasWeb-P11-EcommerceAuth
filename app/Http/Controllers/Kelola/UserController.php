<?php

namespace App\Http\Controllers\Kelola;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// kelola user & role, khusus admin (route-nya dilindungi middleware role:admin)
class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');

        $users = User::withCount('orders')
            ->when(in_array($role, [User::ROLE_ADMIN, User::ROLE_EDITOR, User::ROLE_USER], true), fn ($q) => $q->where('role', $role))
            ->orderByRaw("FIELD(role, 'admin', 'editor', 'user')")
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('kelola.users.index', compact('users', 'role'));
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_EDITOR, User::ROLE_USER])],
        ]);

        // biar admin ga sengaja nurunin role dirinya sendiri
        if ($user->is($request->user())) {
            return back()->with('error', 'Kamu tidak bisa mengubah role akunmu sendiri.');
        }

        // role tidak fillable, jadi di-set langsung
        $user->role = $data['role'];
        $user->save();

        return back()->with('success', "Role {$user->name} diubah jadi {$user->role}.");
    }
}
