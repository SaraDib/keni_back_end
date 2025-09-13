<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
class RoleController extends Controller
{
    //
     // Lister tous les rôles
    public function index()
    {
        return response()->json(Role::all());
    }

    // Ajouter un rôle
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:roles,nom',
            'description' => 'nullable|string',
            'color' => 'nullable|string'
        ]);

        $role = Role::create($request->only('nom', 'description', 'color'));

        return response()->json($role, 201);
    }

    // Mettre à jour un rôle
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'nom'        => [
                'required',
                'string',
                'max:100',
                Rule::unique('roles', 'nom')->ignore($role->id),
            ],
            'description'=> 'nullable|string|max:1000',
            'color'      => 'nullable|string|max:20',
        ]);

        $role->update($validated);

        return response()->json($role);
    }
    // Supprimer un rôle (protégé + en usage)
public function destroy(Role $role)
{
    // 1) Protection : empêcher la suppression du rôle "admin"
    if (strtolower($role->nom) === 'admin') {
        return response()->json([
            'message' => 'Le rôle "admin" est protégé et ne peut pas être supprimé.',
        ], 403);
    }

    // 2) Empêcher la suppression si des utilisateurs utilisent encore ce rôle
    $isUsed = \App\Models\User::where('Role', $role->nom)->exists();
    if ($isUsed) {
        return response()->json([
            'message' => 'Ce rôle est encore assigné à des utilisateurs. Retirez-le des utilisateurs avant de le supprimer.',
        ], 422);
    }

    $role->delete();

    return response()->json([
        'message' => 'Rôle supprimé avec succès.',
    ]);
}

}
