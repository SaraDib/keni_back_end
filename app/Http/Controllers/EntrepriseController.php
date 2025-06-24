<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Entreprise;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class EntrepriseController extends Controller
{
    public function index()
    {
        $entreprises = Entreprise::with(['users', 'services', 'contactUs', 'faqs', 'equipes', 'centres'])->get();
        return response()->json($entreprises);
    }

    public function show($id)
    {
        $entreprise = Entreprise::with(['users', 'services', 'contactUs', 'faqs', 'equipes', 'centres'])->findOrFail($id);
        return response()->json($entreprise);
    }

    public function store(Request $request)
    {
        try {
            // Define validation rules
            $rules = [
                'Nom' => 'required|string|unique:entreprises,Nom',
                'Logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'Telephone' => 'nullable|string',
                'Whatsapp' => 'nullable|string',
                'Email' => 'nullable|email',
                'Adresse' => 'nullable|string',
                'Facebook' => 'nullable|string',
                'Instagram' => 'nullable|string',
            ];
            // Custom error messages
            $customMessages = [
                'Nom.required' => 'Le nom est requis.',
                'Nom.unique' => 'Ce nom est déjà enregistré.',
                'Logo.image' => 'Le logo doit être une image.',
                'Logo.mimes' => 'Le logo doit être de type jpeg, png, jpg, gif ou svg.',
                'Logo.max' => 'Le logo ne doit pas dépasser 2048 Ko.',
                'Email.email' => 'L\'adresse email n\'est pas valide.',
            ];
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            // Process the validated data
            $validatedData = $validator->validated();

            // Handle file upload for Logo
            if ($request->hasFile('Logo')) {
                $file = $request->file('Logo');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('entreprise_logos', $fileName);
                $validatedData['Logo'] = $path;
            }

            // Create a new entreprise
            $entreprise = Entreprise::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Entreprise créée avec succès',
                'data' => $entreprise
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
                'message' => 'Une erreur s\'est produite lors du traitement de votre demande',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $entreprise = Entreprise::findOrFail($id);

            // Define validation rules
            $rules = [
                'Nom' => 'sometimes|required|string|unique:entreprises,Nom,' . $id . ',ID_Entreprise',
                'Logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'Telephone' => 'nullable|string',
                'Whatsapp' => 'nullable|string',
                'Email' => 'nullable|email',
                'Adresse' => 'nullable|string',
                'Facebook' => 'nullable|string',
                'Instagram' => 'nullable|string',
            ];
            // Custom error messages
            $customMessages = [
                'Nom.required' => 'Le nom est requis.',
                'Nom.unique' => 'Ce nom est déjà enregistré.',
                'Logo.image' => 'Le logo doit être une image.',
                'Logo.mimes' => 'Le logo doit être de type jpeg, png, jpg, gif ou svg.',
                'Logo.max' => 'Le logo ne doit pas dépasser 2048 Ko.',
                'Email.email' => 'L\'adresse email n\'est pas valide.',
            ];
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            // Process the validated data
            $validatedData = $validator->validated();

            // Handle file upload for Logo
            if ($request->hasFile('Logo')) {
                // Delete the old logo if it exists
                if ($entreprise->Logo) {
                    Storage::delete($entreprise->Logo);
                }
                $file = $request->file('Logo');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('entreprise_logos', $fileName);
                $validatedData['Logo'] = $path;
            }

            // Update the entreprise
            $entreprise->fill($validatedData);
            $entreprise->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Entreprise mise à jour avec succès',
                'data' => $entreprise
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'La validation a échoué',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors du traitement de votre demande',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $entreprise = Entreprise::findOrFail($id);

        // Delete the associated logo if it exists
        if ($entreprise->Logo) {
            Storage::delete($entreprise->Logo);
        }

        $entreprise->delete();
        return response()->json(null, 204);
    }

    public function showLogo($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        if ($entreprise->Logo) {
            return response()->file(storage_path('app/' . $entreprise->Logo));
        }
        return response()->json(['message' => 'Aucun logo trouvé pour cette entreprise'], 404);
    }
}