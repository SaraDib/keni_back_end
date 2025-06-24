<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str; // Import Str facade
use App\Models\Horaire;
use Illuminate\Http\Request;

class HoraireController extends Controller
{

    public function index()
    {
        $horaires = Horaire::with('centre')->get();
        return response()->json($horaires);
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'ID_Center' => 'required|exists:centres,ID_Center',
                'Day_Start' => 'required|string|max:255',
                'Day_Start_AR' => 'required|string|max:255',
                'Time_Start' => 'required|date_format:H:i',
                'Time_End' => 'required|date_format:H:i',
                'isClosed' => 'boolean',
            ];

            $customMessages = [
                'ID_Center.required' => 'L\'ID du centre est requis.',
                'ID_Center.exists' => 'Le centre sélectionné n\'existe pas.',
                'Day_Start.required' => 'Le jour de début est requis.',
                'Day_Start_AR.required' => 'Le jour arabic est requis.',
                'Time_Start.required' => 'L\'heure de début est requise.',
                'Time_Start.date_format' => 'L\'heure de début doit être au format HH:MM.',
                'Time_End.required' => 'L\'heure de fin est requise.',
                'Time_End.date_format' => 'L\'heure de fin doit être au format HH:MM.',
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $horaire = Horaire::create($validator->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Horaire créé avec succès',
                'data' => $horaire
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
                'message' => 'Une erreur s\'est produite lors de la création de l\'horaire',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $horaire = Horaire::with('centre')->findOrFail($id);
        return response()->json($horaire);
    }

    public function update(Request $request, $id)
    {
        $horaire = Horaire::findOrFail($id);
        
        $request->validate([
            'ID_Center' => 'sometimes|required|exists:centres,ID_Center',
            'Day_Start' => 'sometimes|required|string|max:255',
            'Day_Start_AR' => 'sometimes|required|string|max:255',
            'Time_Start' => 'sometimes|required|date_format:H:i',
            'Time_End' => 'sometimes|required|date_format:H:i',
            'isClosed' => 'boolean',
        ]);

        $horaire->update($request->all());
        return response()->json($horaire);
    }

    public function destroy($id)
    {
        $horaire = Horaire::findOrFail($id);
        $horaire->delete();
        return response()->json(null, 204);
    }
}