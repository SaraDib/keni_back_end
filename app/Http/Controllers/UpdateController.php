<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    public function index()
    {
        $update = Update::first(); // Get the first update, regardless of active status
        return response()->json($update);
    }

    public function store(Request $request)
    {
        // Check if an update already exists
        if (Update::exists()) {
            return response()->json(['message' => 'Une mise à jour existe déjà. Veuillez la modifier ou la supprimer.'], 400);
        }

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title_fr' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'description_fr' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $update = new Update();
        $update->title_fr = $request->title_fr;
        $update->title_ar = $request->title_ar;
        $update->description_fr = $request->description_fr;
        $update->description_ar = $request->description_ar;
        $update->active = $request->active ?? true;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('updates', 'public');
            $update->image_path = $path;
        }

        $update->save();

        return response()->json($update, 201);
    }

    public function show($id)
    {
        $update = Update::findOrFail($id);
        return response()->json($update);
    }

    public function update(Request $request, $id)
    {
        $update = Update::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title_fr' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'description_fr' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $update->title_fr = $request->title_fr ?? $update->title_fr;
        $update->title_ar = $request->title_ar ?? $update->title_ar;
        $update->description_fr = $request->description_fr ?? $update->description_fr;
        $update->description_ar = $request->description_ar ?? $update->description_ar;
        $update->active = $request->active ?? $update->active;

        if ($request->hasFile('image')) {
            if ($update->image_path) {
                Storage::disk('public')->delete($update->image_path);
            }
            $path = $request->file('image')->store('updates', 'public');
            $update->image_path = $path;
        }

        $update->save();

        return response()->json($update);
    }

    public function destroy($id)
    {
        $update = Update::findOrFail($id);
        if ($update->image_path) {
            Storage::disk('public')->delete($update->image_path);
        }
        $update->delete();
        return response()->json(null, 204);
    }

    public function showImage($id)
    {
        $update = Update::findOrFail($id);
        if (!$update->image_path) {
            Log::error("Image not found for update ID: {$id}");
            return response()->json(['message' => 'Aucune image trouvée pour cette mise à jour'], 404);
        }

        $path = storage_path('app/public/' . $update->image_path);
        if (!file_exists($path)) {
            Log::error("Image file does not exist at path: {$path}");
            return response()->json(['message' => 'Fichier image introuvable'], 404);
        }

        $mime = mime_content_type($path);
        return response()->file($path, ['Content-Type' => $mime]);
    }
}