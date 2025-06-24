<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RowService;
use Exception;
use Illuminate\Validation\ValidationException;

class RowServiceController extends Controller
{
    public function index()
    {
        $rowServices = RowService::with(['service', 'typePhoto', 'photos'])->orderBy('Classement')->get();
        return response()->json($rowServices);
    }

    public function show($id)
    {
        $rowService = RowService::with(['service', 'typePhoto', 'photos'])->findOrFail($id);
        return response()->json($rowService);
    }

    public function store(Request $request)
    {
        try {
            // Define validation rules
            $rules = [
                'ID_Service' => 'required|exists:services,ID_Service',
                'ID_Type_Photo' => 'required|exists:type_photos,ID_Type_Photo',
                'Text' => 'nullable|string',
                'TextAR' => 'nullable|string',
                'Classement' => 'nullable|integer',
            ];
            // Custom error messages
            $customMessages = [
                'ID_Service.required' => 'Le service est requis.',
                'ID_Service.exists' => 'Le service sélectionné n\'existe pas.',
                'ID_Type_Photo.required' => 'Le type de photo est requis.',
                'ID_Type_Photo.exists' => 'Le type de photo sélectionné n\'existe pas.',
                'Classement.integer' => 'Le classement doit être un nombre entier.',
            ];
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            // Process the validated data
            $validatedData = $validator->validated();

            // Create a new row service
            $rowService = RowService::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Ligne de service créée avec succès',
                'data' => $rowService
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
            $rowService = RowService::findOrFail($id);

            // Define validation rules
            $rules = [
                'ID_Service' => 'sometimes|required|exists:services,ID_Service',
                'ID_Type_Photo' => 'sometimes|required|exists:type_photos,ID_Type_Photo',
                'Text' => 'nullable|string',
                'TextAR' => 'nullable|string',
                'Classement' => 'nullable|integer',
            ];
            // Custom error messages
            $customMessages = [
                'ID_Service.required' => 'Le service est requis.',
                'ID_Service.exists' => 'Le service sélectionné n\'existe pas.',
                'ID_Type_Photo.required' => 'Le type de photo est requis.',
                'ID_Type_Photo.exists' => 'Le type de photo sélectionné n\'existe pas.',
                'Classement.integer' => 'Le classement doit être un nombre entier.',
            ];
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            // Process the validated data
            $validatedData = $validator->validated();

            // Update the row service
            $rowService->fill($validatedData);
            $rowService->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Ligne de service mise à jour avec succès',
                'data' => $rowService
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
        $rowService = RowService::findOrFail($id);
        $rowService->delete();
        return response()->json(null, 204);
    }
}