<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EquipeController extends Controller
{

    public function index()
    {
        try {
            $equipes = Equipe::with('entreprise')->get();
            return response()->json($equipes);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la récupération des équipes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'ID_Entreprise' => 'required|exists:entreprises,ID_Entreprise',
                'Nom' => 'required|string|max:255',
                'NomAR' => 'required|string|max:255',
                'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'Profession' => 'required|string|max:255',
                'Description' => 'nullable|string',
                'ProfessionAR' => 'required|string|max:255',
                'DescriptionAR' => 'nullable|string',
            ];

            $customMessages = [
                'ID_Entreprise.required' => 'L\'ID de l\'entreprise est requis.',
                'ID_Entreprise.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
                'Nom.required' => 'Le nom est requis.',
                'Nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
                'NomAR.required' => 'Le nom est requis.',
                'NomAR.max' => 'Le nom ne doit pas dépasser 255 caractères.',
                'Image.image' => 'L\'image doit être une image.',
'Image.mimes' => 'L\'image doit être de type jpeg, png, jpg, gif ou svg.',
'Image.max' => 'L\'image ne doit pas dépasser 2048 Ko.',
                'Profession.required' => 'La profession est requise.',
                'Profession.max' => 'La profession ne doit pas dépasser 255 caractères.',
                'ProfessionAR.required' => 'La profession est requise.',
                'ProfessionAR.max' => 'La profession ne doit pas dépasser 255 caractères.',
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $validatedData = $validator->validated();

// Handle file upload for Image
if ($request->hasFile('Image')) {
    $file = $request->file('Image');
    $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('equipe_images', $fileName);
    $validatedData['Image'] = $path;
}

$equipe = Equipe::create($validatedData);
            return response()->json([
                'status' => 'success',
                'message' => 'Équipe créée avec succès',
                'data' => $equipe
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'La validation a échoué',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la création de l\'équipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $equipe = Equipe::with('entreprise')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $equipe
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la récupération de l\'équipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $equipe = Equipe::findOrFail($id);
            
            $rules = [
                'ID_Entreprise' => 'sometimes|required|exists:entreprises,ID_Entreprise',
                'Nom' => 'sometimes|required|string|max:255',
                'NomAR' => 'sometimes|required|string|max:255',
                'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'Profession' => 'sometimes|required|string|max:255',
                'Description' => 'nullable|string',
                'ProfessionAR' => 'sometimes|required|string|max:255',
                'DescriptionAR' => 'nullable|string',
            ];

            $customMessages = [
                'ID_Entreprise.required' => 'L\'ID de l\'entreprise est requis.',
                'ID_Entreprise.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
                'Nom.required' => 'Le nom est requis.',
                'Nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
                'NomAR.required' => 'Le nom est requis.',
                'NomAR.max' => 'Le nom ne doit pas dépasser 255 caractères.',
                'Image.image' => 'L\'image doit être une image.',
'Image.mimes' => 'L\'image doit être de type jpeg, png, jpg, gif ou svg.',
'Image.max' => 'L\'image ne doit pas dépasser 2048 Ko.',
                'Profession.required' => 'La profession est requise.',
                'Profession.max' => 'La profession ne doit pas dépasser 255 caractères.',
                'ProfessionAR.required' => 'La profession est requise.',
                'ProfessionAR.max' => 'La profession ne doit pas dépasser 255 caractères.',
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $validatedData = $validator->validated();

// Handle file upload for Image
if ($request->hasFile('Image')) {
    // Delete the old image if it exists
    if ($equipe->Image) {
        Storage::delete($equipe->Image);
    }
    $file = $request->file('Image');
    $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('equipe_images', $fileName);
    $validatedData['Image'] = $path;
}

$equipe->update($validatedData);
            return response()->json([
                'status' => 'success',
                'message' => 'Équipe mise à jour avec succès',
                'data' => $equipe
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'La validation a échoué',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la mise à jour de l\'équipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $equipe = Equipe::findOrFail($id);

        // Delete the associated image if it exists
        if ($equipe->Image) {
            Storage::delete($equipe->Image);
        }

        $equipe->delete();
        return response()->json(null, 204);
    }

    public function showImage($id)
    {
        $equipe = Equipe::findOrFail($id);
        if ($equipe->Image) {
            return response()->file(storage_path('app/' . $equipe->Image));
        }
        return response()->json(['message' => 'Image non trouvée pour ce membre de l\'équipe'], 404);
    }
}