<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['entreprise', 'rowServices' ])->get();
        return response()->json($services);
    }

    public function show($id)
    {
        $service = Service::with(['entreprise', 'rowServices','rowServices.photos'])->findOrFail($id);
        return response()->json($service);
    }

    public function store(Request $request)
    {
        try {
            // Define validation rules
            $rules = [
                'ID_Entreprise' => 'required|exists:entreprises,ID_Entreprise',
                'Nom' => 'required|string',
                'NomAR' => 'required|string',
                'Descriptions' => 'nullable|string',
                'DescriptionsAR' => 'nullable|string',
                'Photos' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'Etat' => 'nullable|boolean',
            ];
            // Custom error messages
            $customMessages = [
                'ID_Entreprise.required' => 'L\'entreprise est requise.',
                'ID_Entreprise.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
                'Nom.required' => 'Le nom est requis.',
                'Photos.image' => 'La photo doit être une image.',
                'Photos.mimes' => 'La photo doit être de type jpeg, png, jpg, gif ou svg.',
                'Photos.max' => 'La photo ne doit pas dépasser 2048 Ko.',
            ];
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            // Process the validated data
            $validatedData = $validator->validated();

            // Handle file upload for Photos
            if ($request->hasFile('Photos')) {
                $file = $request->file('Photos');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('service_photos', $fileName);
                $validatedData['Photos'] = $path;
            }

            // Create a new service
            $service = Service::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Service créé avec succès',
                'data' => $service
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
            $service = Service::findOrFail($id);

            // Define validation rules
            $rules = [
                'ID_Entreprise' => 'sometimes|required|exists:entreprises,ID_Entreprise',
                'Nom' => 'sometimes|required|string',
                'Descriptions' => 'nullable|string',
                'NomAR' => 'sometimes|required|string',
                'DescriptionsAR' => 'nullable|string',
                'Photos' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'Etat' => 'nullable|boolean',
            ];
            // Custom error messages
            $customMessages = [
                'ID_Entreprise.required' => 'L\'entreprise est requise.',
                'ID_Entreprise.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
                'Nom.required' => 'Le nom est requis.',
                'Photos.image' => 'La photo doit être une image.',
                'Photos.mimes' => 'La photo doit être de type jpeg, png, jpg, gif ou svg.',
                'Photos.max' => 'La photo ne doit pas dépasser 2048 Ko.',
            ];
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            // Process the validated data
            $validatedData = $validator->validated();

            // Handle file upload for Photos
            if ($request->hasFile('Photos')) {
                // Delete the old photo if it exists
                if ($service->Photos) {
                    Storage::delete($service->Photos);
                }
                $file = $request->file('Photos');
                $fileName = now()->format('Y-m-d_His') . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('service_photos', $fileName);
                $validatedData['Photos'] = $path;
            }

            // Update the service
            $service->fill($validatedData);
            $service->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Service mis à jour avec succès',
                'data' => $service
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
        $service = Service::findOrFail($id);

        // Delete the associated photo if it exists
        if ($service->Photos) {
            Storage::delete($service->Photos);
        }

        $service->delete();
        return response()->json(null, 204);
    }
    
    public function showPhoto($id)
    {
        $service = Service::findOrFail($id);
        if ($service->Photos) {
            return response()->file(storage_path('app/' . $service->Photos));
        }
        return response()->json(['message' => 'Aucune photo trouvée pour ce service'], 404);
    }
}