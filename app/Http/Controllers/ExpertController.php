<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ExpertController extends Controller
{
    public function index()
    {
        $experts = Expert::all();
        return response()->json($experts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'VideoURL' => 'nullable|file|mimes:mp4,webm', // Max 100MB
            'Image' => 'image|mimes:jpeg,png,jpg,gif,webp',
            'TitleFR' => 'string|max:255',
            'TitleAR' => 'string|max:255',
            'DescriptionFR' => 'string',
            'DescriptionAR' => 'string',
            'Etat' => 'boolean',
        ]);

        $expert = new Expert();
        $expert->TitleFR = $request->TitleFR;
        $expert->TitleAR = $request->TitleAR;
        $expert->DescriptionFR = $request->DescriptionFR;
        $expert->DescriptionAR = $request->DescriptionAR;
        $expert->Etat = $request->Etat ?? true;

        if ($request->hasFile('VideoURL')) {
            $path = $request->file('VideoURL')->store('videos', 'public');
            $expert->VideoURL = $path; // Store relative path without /storage/
        }

        if ($request->hasFile('Image')) {
            $path = $request->file('Image')->store('experts', 'public');
            $expert->ImagePath = $path; // Store relative path without /storage/
        }

        $expert->save();

        return response()->json($expert, 201);
    }

    public function show($id)
    {
        $expert = Expert::findOrFail($id);
        return response()->json($expert);
    }

    public function update(Request $request, $id)
    {
        $expert = Expert::findOrFail($id);

        $request->validate([
            'VideoURL' => 'nullable|file|mimes:mp4,webm|max:102400',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'TitleFR' => 'string|max:255',
            'TitleAR' => 'string|max:255',
            'DescriptionFR' => 'string',
            'DescriptionAR' => 'string',
            'Etat' => 'boolean',
        ]);

        $expert->TitleFR = $request->TitleFR;
        $expert->TitleAR = $request->TitleAR;
        $expert->DescriptionFR = $request->DescriptionFR;
        $expert->DescriptionAR = $request->DescriptionAR;
        $expert->Etat = $request->Etat ?? $expert->Etat;

        if ($request->hasFile('VideoURL')) {
            if ($expert->VideoURL) {
                Storage::disk('public')->delete($expert->VideoURL);
            }
            $path = $request->file('VideoURL')->store('videos', 'public');
            $expert->VideoURL = $path;
        }

        if ($request->hasFile('Image')) {
            if ($expert->ImagePath) {
                Storage::disk('public')->delete($expert->ImagePath);
            }
            $path = $request->file('Image')->store('experts', 'public');
            $expert->ImagePath = $path;
        }

        $expert->save();

        return response()->json($expert);
    }

    public function destroy($id)
    {
        $expert = Expert::findOrFail($id);
        if ($expert->VideoURL) {
            Storage::disk('public')->delete($expert->VideoURL);
        }
        if ($expert->ImagePath) {
            Storage::disk('public')->delete($expert->ImagePath);
        }
        $expert->delete();
        return response()->json(null, 204);
    }

    public function toggleStatus($id)
    {
        $expert = Expert::findOrFail($id);
        $expert->Etat = !$expert->Etat;
        $expert->save();
        return response()->json($expert);
    }

    public function getExpertImage($id)
    {
        $expert = Expert::findOrFail($id);
        if (!$expert->ImagePath) {
            Log::error("Image not found for expert ID: {$id}");
            return response()->json(['message' => 'Aucune image trouvée pour cet expert'], 404);
        }

        $path = storage_path('app/public/' . $expert->ImagePath);
        if (!file_exists($path)) {
            Log::error("Image file does not exist at path: {$path}");
            return response()->json(['message' => 'Fichier image introuvable'], 404);
        }

        $mime = mime_content_type($path);
        return response()->file($path, ['Content-Type' => $mime]);
    }

    public function getExpertVideo($id)
    {
        $expert = Expert::findOrFail($id);
        if (!$expert->VideoURL) {
            Log::error("Video not found for expert ID: {$id}");
            return response()->json(['message' => 'Aucune vidéo trouvée pour cet expert'], 404);
        }

        $path = storage_path('app/public/' . $expert->VideoURL);
        if (!file_exists($path)) {
            Log::error("Video file does not exist at path: {$path}");
            return response()->json(['message' => 'Fichier vidéo introuvable'], 404);
        }

        $mime = mime_content_type($path);
        return response()->file($path, ['Content-Type' => $mime]);
    }
}
?>