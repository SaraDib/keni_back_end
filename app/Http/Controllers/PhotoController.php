<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Photo;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::with('rowService')->get();
        return response()->json($photos);
    }

    public function show($id)
    {
        $photo = Photo::with('rowService')->findOrFail($id);
        return response()->json($photo);
    }

    public function store(Request $request)
    {
        try {
            // Define validation rules
            $rules = [
                'ID_Row' => 'required|exists:row_services,ID_Row',
                'Photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
            // Custom error messages
            $customMessages = [
                'ID_Row.required' => 'La ligne de service est requise.',
                'ID_Row.exists' => 'La ligne de service sélectionnée n\'existe pas.',
                'Photo.required' => 'La photo est requise.',
                'Photo.image' => 'Le fichier doit être une image.',
                'Photo.mimes' => 'La photo doit être de type jpeg, png, jpg, gif ou svg.',
                'Photo.max' => 'La photo ne doit pas dépasser 2048 Ko.',
            ];
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            // Process the validated data
            $validatedData = $validator->validated();

            // Handle file upload for Photo
            if ($request->hasFile('Photo')) {
                $file = $request->file('Photo');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('row_service_photos', $fileName);
                $validatedData['Photo'] = $path;
            }

            // Create a new photo
            $photo = Photo::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Photo créée avec succès',
                'data' => $photo
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
            $photo = Photo::findOrFail($id);

            // Define validation rules
            $rules = [
                'ID_Row' => 'sometimes|required|exists:row_services,ID_Row',
                'Photo' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
            // Custom error messages
            $customMessages = [
                'ID_Row.required' => 'La ligne de service est requise.',
                'ID_Row.exists' => 'La ligne de service sélectionnée n\'existe pas.',
                'Photo.required' => 'La photo est requise.',
                'Photo.image' => 'Le fichier doit être une image.',
                'Photo.mimes' => 'La photo doit être de type jpeg, png, jpg, gif ou svg.',
                'Photo.max' => 'La photo ne doit pas dépasser 2048 Ko.',
            ];
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            // Process the validated data
            $validatedData = $validator->validated();

            // Handle file upload for Photo
            if ($request->hasFile('Photo')) {
                // Delete the old photo if it exists
                if ($photo->Photo) {
                    Storage::delete($photo->Photo);
                }
                $file = $request->file('Photo');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('row_service_photos', $fileName);
                $validatedData['Photo'] = $path;
            }

            // Update the photo
            $photo->fill($validatedData);
            $photo->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Photo mise à jour avec succès',
                'data' => $photo
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
        $photo = Photo::findOrFail($id);
        
        // Delete the associated photo file if it exists
        if ($photo->Photo) {
            Storage::delete($photo->Photo);
        }
        
        $photo->delete();
        return response()->json(null, 204);
    }
    
    public function showPhoto($id)
    {
        $photo = Photo::findOrFail($id);
        if ($photo->Photo) {
            return response()->file(storage_path('app/' . $photo->Photo));
        }
        return response()->json(['message' => 'Aucune photo trouvée'], 404);
    }
}