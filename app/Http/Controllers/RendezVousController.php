<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str; // Import Str facade
use App\Models\RendezVous;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{

    public function index()
    {
        $rendezVous = RendezVous::with('entreprise')->get();
        return response()->json($rendezVous);
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'ID_Entreprise' => 'required|exists:entreprises,ID_Entreprise',
                'Nom' => 'required|string|max:255',
                'Prenom' => 'required|string|max:255',
                'Date_Naissance' => 'nullable|date',
                'Tel' => 'nullable|string|max:255',
                'Email' => 'nullable|email|max:255',
                'Faire' => 'nullable|string|max:255',
                'Type_recette' => 'nullable|string|max:255',
                'nombre' => 'nullable|integer',
                'Ergotherapie' => 'nullable|string|max:255',
                'Physiotherapie' => 'nullable|string|max:255',
                'Remarque' => 'nullable|string',
            ];

            $customMessages = [
                'ID_Entreprise.required' => 'L\'ID de l\'entreprise est requis.',
                'ID_Entreprise.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
                'Nom.required' => 'Le nom est requis.',
                'Prenom.required' => 'Le prénom est requis.',
                'Date_Naissance.date' => 'La date de naissance doit être une date valide.',
                'Email.email' => 'L\'email doit être une adresse email valide.',
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $rendezVous = RendezVous::create($validator->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Rendez-vous créé avec succès',
                'data' => $rendezVous
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
                'message' => 'Une erreur s\'est produite lors de la création du rendez-vous',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $rendezVous = RendezVous::with('entreprise')->findOrFail($id);
        return response()->json($rendezVous);
    }

    public function update(Request $request, $id)
    {
        $rendezVous = RendezVous::findOrFail($id);
        
        $request->validate([
            'ID_Entreprise' => 'sometimes|required|exists:entreprises,ID_Entreprise',
            'Nom' => 'sometimes|required|string|max:255',
            'Prenom' => 'sometimes|required|string|max:255',
            'Date_Naissance' => 'nullable|date',
            'Tel' => 'nullable|string|max:255',
            'Email' => 'nullable|email|max:255',
            'Faire' => 'nullable|string|max:255',
            'Type_recette' => 'nullable|string|max:255',
            'nombre' => 'nullable|integer',
            'Ergotherapie' => 'nullable|string|max:255',
            'Physiotherapie' => 'nullable|string|max:255',
            'Remarque' => 'nullable|string',
        ]);

        $rendezVous->update($request->all());
        return response()->json($rendezVous);
    }

    public function destroy($id)
    {
        $rendezVous = RendezVous::findOrFail($id);
        $rendezVous->delete();
        return response()->json(null, 204);
    }
}