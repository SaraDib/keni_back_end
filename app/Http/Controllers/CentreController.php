<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str; 

use App\Models\Centre;


class CentreController extends Controller
{

    public function index()
    {
        $centres = Centre::with(['entreprise', 'horaires'])->get();
        return response()->json($centres);
    }


    public function store(Request $request)
    {
        try {
            $rules = [
                'ID_Entreprise' => 'required|exists:entreprises,ID_Entreprise',
                'Nom' => 'required|string|max:255',
                'NomAR'=>'required|string|max:255',
                'Adresse' => 'nullable|string|max:255',
                'AdresseAR' => 'nullable|string|max:255',
                'Telephone' => 'nullable|string|max:255',
                'Fix' => 'nullable|string|max:255',
                'Email' => 'nullable|email|max:255',
                'Handicapes' => 'boolean',
                'Positions' => 'string'
            ];

            $customMessages = [
                'ID_Entreprise.required' => 'L\'ID de l\'entreprise est requis.',
                'ID_Entreprise.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
                'Nom.required' => 'Le nom est requis.',
                'NomAR.required' => 'Le nom arabic est requis.',
                'Email.email' => 'L\'email doit être une adresse email valide.',
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $centre = Centre::create($validator->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Centre créé avec succès',
                'data' => $centre
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
                'message' => 'Une erreur s\'est produite lors de la création du centre',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        $centre = Centre::with(['entreprise', 'horaires'])->findOrFail($id);
        return response()->json($centre);
    }


    public function update(Request $request, $id)
    {
        $centre = Centre::findOrFail($id);
        
        $request->validate([
            'ID_Entreprise' => 'sometimes|required|exists:entreprises,ID_Entreprise',
            'Nom' => 'sometimes|required|string|max:255',
            'NomAR' => 'sometimes|required|string|max:255',
            'Adresse' => 'nullable|string|max:255',
            'AdresseAR' => 'nullable|string|max:255',
            'Telephone' => 'nullable|string|max:255',
            'Fix' => 'nullable|string|max:255',
            'Email' => 'nullable|email|max:255',
            'Handicapes' => 'boolean',
            'Positions' => 'string'
        ]);

        $centre->update($request->all());
        return response()->json($centre);
    }


    public function destroy($id)
    {
        $centre = Centre::findOrFail($id);
        $centre->delete();
        return response()->json(null, 204);
    }
}