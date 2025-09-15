<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller {

    // 1️⃣ Récupérer toutes les images
     public function index(Request $request) {
        $nomPage = $request->query('nom_page');

        if ($nomPage) {
            return SliderImage::where('nom_page', $nomPage)->get();
        }

        return SliderImage::all();
    }

    public function store(Request $request) {
        $request->validate([
            'sliderImages.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'nom_page' => 'required|string|max:100', // validation du nom de la page
        ]);

        $uploadedImages = [];
        if ($request->hasFile('sliderImages')) {
            foreach ($request->file('sliderImages') as $file) {
                $path = $file->store('public/slider');
                $image = SliderImage::create([
                    'Path' => str_replace('public/', '', $path),
                    'nom_page' => $request->nom_page
                ]);
                $uploadedImages[] = $image;
            }
        }

        return response()->json([
            'message' => 'Images ajoutées avec succès',
            'data' => $uploadedImages
        ]);
    }

    // 3️⃣ Supprimer une image
    public function destroy($id) {
        $image = SliderImage::findOrFail($id);
        Storage::delete('public/'.$image->Path);
        $image->delete();

        return response()->json(['message' => 'Image supprimée avec succès']);
    }
}
