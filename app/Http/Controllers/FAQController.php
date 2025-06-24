<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\ValidationException;

class FAQController extends Controller
{

    public function index()
    {
        try {
            $faqs = FAQ::with('entreprise')->get();
            return response()->json($faqs);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la récupération des FAQs',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $rules = [
                'ID_Entreprise' => 'required|exists:entreprises,ID_Entreprise',
                'Question' => 'required|string',
                'Reponse' => 'required|string',
                'QuestionAR' => 'required|string',
                'ReponseAR' => 'required|string',
            ];

            $customMessages = [
                'ID_Entreprise.required' => 'L\'ID de l\'entreprise est requis.',
                'ID_Entreprise.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
                'Question.required' => 'La question est requise.',
                'Reponse.required' => 'La réponse est requise.',
                'QuestionAR.required' => 'La question est requise.',
                'ReponseAR.required' => 'La réponse est requise.',
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $faq = FAQ::create($validator->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'FAQ créée avec succès',
                'data' => $faq
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
                'message' => 'Une erreur s\'est produite lors de la création de la FAQ',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $faq = FAQ::with('entreprise')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $faq
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la récupération de la FAQ',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            
            $rules = [
                'ID_Entreprise' => 'sometimes|required|exists:entreprises,ID_Entreprise',
                'Question' => 'sometimes|required|string',
                'Reponse' => 'sometimes|required|string',
                'QuestionAR' => 'sometimes|required|string',
                'ReponseAR' => 'sometimes|required|string',
            ];

            $customMessages = [
                'ID_Entreprise.required' => 'L\'ID de l\'entreprise est requis.',
                'ID_Entreprise.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
                'Question.required' => 'La question est requise.',
                'Reponse.required' => 'La réponse est requise.',
                'Question.requiredAR' => 'La question est requise.',
                'Reponse.requiredAR' => 'La réponse est requise.',
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La validation a échoué',
                    'errors' => $validator->errors()
                ], 422);
            }

            $faq->update($validator->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'FAQ mise à jour avec succès',
                'data' => $faq
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la mise à jour de la FAQ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            $faq->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'FAQ supprimée avec succès'
            ], 204);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la suppression de la FAQ',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}