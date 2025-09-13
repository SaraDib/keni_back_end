<?php

namespace App\Http\Controllers;

use App\Models\Physiotherapie;
use Illuminate\Http\Request;

class PhysiotherapieController extends Controller
{
    public function index()
    {
        return response()->json(Physiotherapie::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:physiotherapie,nom',
        ]);

        $service = Physiotherapie::create($request->all());
        return response()->json($service, 201);
    }

    public function show($id)
    {
        $service = Physiotherapie::findOrFail($id);
        return response()->json($service);
    }

    public function update(Request $request, $id)
    {
        $service = Physiotherapie::findOrFail($id);
        $request->validate([
            'nom' => 'required|string|unique:physiotherapie,nom,' . $id,
        ]);

        $service->update($request->all());
        return response()->json($service);
    }

    public function destroy($id)
    {
        $service = Physiotherapie::findOrFail($id);
        $service->delete();
        return response()->json(null, 204);
    }
}
