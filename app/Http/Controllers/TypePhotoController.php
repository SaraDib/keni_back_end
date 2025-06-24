<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TypePhoto;
use Exception;
use Illuminate\Validation\ValidationException;

class TypePhotoController extends Controller
{
    public function index()
    {
        $typePhotos = TypePhoto::with('rowServices')->get();
        return response()->json($typePhotos);
    }

    public function show($id)
    {
        $typePhoto = TypePhoto::with('rowServices')->findOrFail($id);
        return response()->json($typePhoto);
    }

    public function store(Request $request)
    {
        try {
            // Define validation rules
            $rules = [
                'Nom' => 'required|string|unique:type_photos,Nom',
            ];
            // Custom error messages
            $customMessages = [
                'Nom.required' => 'Le nom est requis.',
                'Nom.unique' => 'Ce nom est déjà enregistré.',
            ];
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            // Process the validated data
            $validatedData = $validator->validated();

            // Create a new type photo
            $typePhoto = TypePhoto::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Type de photo créé avec succès',
                'data' => $typePhoto
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
            $typePhoto = TypePhoto::findOrFail($id);

            // Define validation rules
            $rules = [
                'Nom' => 'sometimes|required|string|unique:type_photos,Nom,' . $id . ',ID_Type_Photo',
            ];
            // Custom error messages
            $customMessages = [
                'Nom.required' => 'Le nom est requis.',
                'Nom.unique' => 'Ce nom est déjà enregistré.',
            ];
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            // Process the validated data
            $validatedData = $validator->validated();

            // Update the type photo
            $typePhoto->fill($validatedData);
            $typePhoto->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Type de photo mis à jour avec succès',
                'data' => $typePhoto
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
        $typePhoto = TypePhoto::findOrFail($id);
        $typePhoto->delete();
        return response()->json(null, 204);
    }
}