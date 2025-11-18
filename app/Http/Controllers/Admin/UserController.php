<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required|in:cliente,vendedor,admin',
        ]);

        $user = User::findOrFail($id);
        $user->update(['role' => $validated['role']]);

        return redirect()->back()->with('success', 'Rol actualizado correctamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Usuario eliminado');
    }
}
