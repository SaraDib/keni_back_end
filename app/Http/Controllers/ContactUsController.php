<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str; // Import Str facade
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{

    public function index()
    {
        $contacts = ContactUs::with('entreprise')->get();
        return response()->json($contacts);
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'ID_Entreprise' => 'required|exists:entreprises,ID_Entreprise',
                'Nom' => 'required|string|max:255',
                'Email' => 'required|email|max:255',
                'Telephone' => 'nullable|string|max:255',
                'Message' => 'required|string',
            ];

            $customMessages = [
                'ID_Entreprise.required' => 'L\'ID de l\'entreprise est requis.',
                'ID_Entreprise.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
                'Nom.required' => 'Le nom est requis.',
                'Email.required' => 'L\'email est requis.',
                'Email.email' => 'L\'email doit être une adresse email valide.',
                'Message.required' => 'Le message est requis.',
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $contact = ContactUs::create($validator->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Contact créé avec succès',
                'data' => $contact
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
                'message' => 'Une erreur s\'est produite lors de la création du contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $contact = ContactUs::with('entreprise')->findOrFail($id);
        return response()->json($contact);
    }

    public function update(Request $request, $id)
    {
        $contact = ContactUs::findOrFail($id);
        
        $request->validate([
            'ID_Entreprise' => 'sometimes|required|exists:entreprises,ID_Entreprise',
            'Nom' => 'sometimes|required|string|max:255',
            'Email' => 'sometimes|required|email|max:255',
            'Telephone' => 'nullable|string|max:255',
            'Message' => 'sometimes|required|string',
        ]);

        $contact->update($request->all());
        return response()->json($contact);
    }

    public function destroy($id)
    {
        $contact = ContactUs::findOrFail($id);
        $contact->delete();
        return response()->json(null, 204);
    }
}