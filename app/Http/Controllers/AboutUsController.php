<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;
use Illuminate\Support\Facades\Validator;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::all();
        return response()->json($aboutUs, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description_fr' => 'required|string|min:3',
            'description_ar' => 'required|string|min:3',
            'active' => 'boolean',
        ], [
            'description_fr.required' => 'La description en français est requise.',
            'description_fr.min' => 'La description en français doit contenir au moins 3 caractères.',
            'description_ar.required' => 'La description en arabe est requise.',
            'description_ar.min' => 'La description en arabe doit contenir au moins 3 caractères.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $aboutUs = AboutUs::create([
            'description_fr' => $request->description_fr,
            'description_ar' => $request->description_ar,
            'active' => $request->active ?? true,
        ]);

        return response()->json($aboutUs, 201);
    }

    public function update(Request $request, $id)
    {
        $aboutUs = AboutUs::find($id);
        if (!$aboutUs) {
            return response()->json(['message' => 'About Us section not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'description_fr' => 'required|string|min:3',
            'description_ar' => 'required|string|min:3',
            'active' => 'boolean',
        ], [
            'description_fr.required' => 'La description en français est requise.',
            'description_fr.min' => 'La description en français doit contenir au moins 3 caractères.',
            'description_ar.required' => 'La description en arabe est requise.',
            'description_ar.min' => 'La description en arabe doit contenir au moins 3 caractères.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $aboutUs->update([
            'description_fr' => $request->description_fr,
            'description_ar' => $request->description_ar,
            'active' => $request->active ?? $aboutUs->active,
        ]);

        return response()->json($aboutUs, 200);
    }

    public function destroy($id)
    {
        $aboutUs = AboutUs::find($id);
        if (!$aboutUs) {
            return response()->json(['message' => 'About Us section not found'], 404);
        }

        $aboutUs->delete();
        return response()->json(['message' => 'About Us section deleted successfully'], 200);
    }
}
