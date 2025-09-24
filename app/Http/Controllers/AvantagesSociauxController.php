<?php

namespace App\Http\Controllers;

use App\Models\AvantagesSociaux;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AvantagesSociauxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $avantages = AvantagesSociaux::all();
            return response()->json($avantages);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des avantages sociaux'], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'paragraphe' => 'required|string'
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('avantages_sociaux', $fileName, 'public');
                $validatedData['photo'] = $path;
            }

            $avantage = AvantagesSociaux::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Avantage social créé avec succès',
                'data' => $avantage
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'avantage social',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $avantage = AvantagesSociaux::findOrFail($id);
            return response()->json($avantage);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Avantage social non trouvé'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $avantage = AvantagesSociaux::find($id);
        
        if (!$avantage) {
            return response()->json([
                'success' => false,
                'message' => 'Avantage social non trouvé'
            ], 404);
        }

        $validatedData = $request->validate([
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'paragraphe' => 'sometimes|required|string'
        ]);

        try {
            // Handle image upload if a new image is provided
            if ($request->hasFile('photo')) {
                // Delete the old image if it exists
                if ($avantage->photo && Storage::disk('public')->exists($avantage->photo)) {
                    Storage::disk('public')->delete($avantage->photo);
                }
                
                $file = $request->file('photo');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('avantages_sociaux', $fileName, 'public');
                $validatedData['photo'] = $path;
            }

            $avantage->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Avantage social mis à jour avec succès',
                'data' => $avantage
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de l\'avantage social',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $avantage = AvantagesSociaux::findOrFail($id);
            
            // Delete the associated image file if it exists
            if ($avantage->photo && Storage::disk('public')->exists($avantage->photo)) {
                Storage::disk('public')->delete($avantage->photo);
            }
            
            $avantage->delete();

            return response()->json(['message' => 'Avantage social supprimé avec succès']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression de l\'avantage social'], 500);
        }
    }
}
