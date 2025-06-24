<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str; // Import Str facade
use App\Models\OffresEmploi;
use Illuminate\Http\Request;

class OffresEmploiController extends Controller
{

    public function index()
    {
        $offresEmploi = OffresEmploi::with('entreprise')->get();
        return response()->json($offresEmploi);
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'ID_Entreprise' => 'required|exists:entreprises,ID_Entreprise',
                'Salutation' => 'required|string|max:255',
                'Nom' => 'required|string|max:255',
                'Rue' => 'required|string|max:255',
                'Code_Postal' => 'required|string|max:255',
                'Ville' => 'required|string|max:255',
                'Email' => 'required|email|max:255',
                'Telephone' => 'required|string|max:255',
                'Profession' => 'required|string|max:255',
                'lettre' => 'nullable|file|mimes:pdf,doc,docx,jpeg,png,jpg,gif,svg|max:2048',
                'CV' => 'nullable|file|mimes:pdf,doc,docx,jpeg,png,jpg,gif,svg|max:2048',
            ];

            $customMessages = [
                'ID_Entreprise.required' => 'L\'ID de l\'entreprise est requis.',
                'ID_Entreprise.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
                'Salutation.required' => 'La salutation est requise.',
                'Nom.required' => 'Le nom est requis.',
                'Rue.required' => 'La rue est requise.',
                'Code_Postal.required' => 'Le code postal est requis.',
                'Ville.required' => 'La ville est requise.',
                'Email.required' => 'L\'email est requis.',
                'Email.email' => 'L\'email doit être une adresse email valide.',
                'Telephone.required' => 'Le téléphone est requis.',
                'Profession.required' => 'La profession est requise.',
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $validatedData = $validator->validated();

            // Handle file upload for lettre
            if ($request->hasFile('lettre')) {
                $file = $request->file('lettre');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('offres_emploi_files', $fileName);
                $validatedData['lettre'] = $path;
            }

            // Handle file upload for CV
            if ($request->hasFile('CV')) {
                $file = $request->file('CV');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('offres_emploi_files', $fileName);
                $validatedData['CV'] = $path;
            }

            $offresEmploi = OffresEmploi::create($validatedData);
            return response()->json([
                'status' => 'success',
                'message' => 'Offre d\'emploi créée avec succès',
                'data' => $offresEmploi
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
                'message' => 'Une erreur s\'est produite lors de la création de l\'offre d\'emploi',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        $offresEmploi = OffresEmploi::with('entreprise')->findOrFail($id);
        return response()->json($offresEmploi);
    }


    public function update(Request $request, $id)
    {
        $offresEmploi = OffresEmploi::findOrFail($id);
        
        $request->validate([
            'ID_Entreprise' => 'sometimes|required|exists:entreprises,ID_Entreprise',
            'Salutation' => 'sometimes|required|string|max:255',
            'Nom' => 'sometimes|required|string|max:255',
            'Rue' => 'sometimes|required|string|max:255',
            'Code_Postal' => 'sometimes|required|string|max:255',
            'Ville' => 'sometimes|required|string|max:255',
            'Email' => 'sometimes|required|email|max:255',
            'Telephone' => 'sometimes|required|string|max:255',
            'Profession' => 'sometimes|required|string|max:255',
            'lettre' => 'nullable|string',
            'CV' => 'nullable|string|max:255',
        ]);

        $validatedData = array_filter($request->all(), function($value) {
                return $value !== null && $value !== '';
            });

            // Handle file upload for lettre
            if ($request->hasFile('lettre')) {
                // Delete the old file if it exists
                if ($offresEmploi->lettre) {
                    Storage::delete($offresEmploi->lettre);
                }
                $file = $request->file('lettre');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('offres_emploi_files', $fileName);
                $validatedData['lettre'] = $path;
            }

            // Handle file upload for CV
            if ($request->hasFile('CV')) {
                // Delete the old file if it exists
                if ($offresEmploi->CV) {
                    Storage::delete($offresEmploi->CV);
                }
                $file = $request->file('CV');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('offres_emploi_files', $fileName);
                $validatedData['CV'] = $path;
            }

            if (!empty($validatedData)) {
                $offresEmploi->update($validatedData);
            }
        return response()->json($offresEmploi);
    }

    public function destroy($id)
    {
        $offresEmploi = OffresEmploi::findOrFail($id);
        // Delete associated files if they exist
            if ($offresEmploi->lettre) {
                Storage::delete($offresEmploi->lettre);
            }
            if ($offresEmploi->CV) {
                Storage::delete($offresEmploi->CV);
            }
            $offresEmploi->delete();
        return response()->json(null, 204);
    }
    
    public function showLettre($id)
    {
        $offresEmploi = OffresEmploi::findOrFail($id);
        
        if (!$offresEmploi->lettre) {
            return response()->json(['message' => 'Lettre not found'], 404);
        }
        
        if (!Storage::exists($offresEmploi->lettre)) {
            return response()->json(['message' => 'Lettre file not found'], 404);
        }
        
        return Storage::download($offresEmploi->lettre);
    }
    
    public function showCV($id)
    {
        $offresEmploi = OffresEmploi::findOrFail($id);
        
        if (!$offresEmploi->CV) {
            return response()->json(['message' => 'CV not found'], 404);
        }
        
        if (!Storage::exists($offresEmploi->CV)) {
            return response()->json(['message' => 'CV file not found'], 404);
        }
        
        return Storage::download($offresEmploi->CV);
    }
}