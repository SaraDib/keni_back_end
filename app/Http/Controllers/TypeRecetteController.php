<?php

namespace App\Http\Controllers;

use App\Models\TypeRecette;
use Illuminate\Http\Request;

class TypeRecetteController extends Controller
{
    // Liste des types
    public function index()
    {
        return response()->json(TypeRecette::all());
    }

    // Ajouter
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:types_recette,nom',
        ]);

        $type = TypeRecette::create($request->all());
        return response()->json($type, 201);
    }

    // Voir un type
    public function show($id)
    {
        $type = TypeRecette::findOrFail($id);
        return response()->json($type);
    }

    // Modifier
    public function update(Request $request, $id)
    {
        $type = TypeRecette::findOrFail($id);
        $request->validate([
            'nom' => 'required|string|unique:types_recette,nom,' . $id,
        ]);

        $type->update($request->all());
        return response()->json($type);
    }

    // Supprimer
    public function destroy($id)
    {
        $type = TypeRecette::findOrFail($id);
        $type->delete();
        return response()->json(null, 204);
    }
}
