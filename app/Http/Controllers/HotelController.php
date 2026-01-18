<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    // LISTE DES HÔTELS
    public function index()
    {
        return response()->json(Hotel::all());
    }

    // CRÉER UN HÔTEL avec upload image
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048', 
        ]);

        // Gérer l'upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('hotels', 'public');
        }

        $hotel = Hotel::create($validated);

        return response()->json($hotel, 201);
    }

    // AFFICHER UN HÔTEL
    public function show(Hotel $hotel)
    {
        return response()->json($hotel);
    }

    // MODIFIER un hôtel avec possibilité de changer l'image
    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'adresse' => 'sometimes|string|max:255',
            'prix' => 'sometimes|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        // Si nouvelle image, supprimer l'ancienne et uploader la nouvelle
        if ($request->hasFile('image')) {
            if ($hotel->image) {
                Storage::disk('public')->delete($hotel->image);
            }
            $validated['image'] = $request->file('image')->store('hotels', 'public');
        }

        $hotel->update($validated);

        return response()->json($hotel);
    }

    // SUPPRIMER un hôtel
    public function destroy(Hotel $hotel)
    {
        if ($hotel->image) {
            Storage::disk('public')->delete($hotel->image);
        }

        $hotel->delete();

        return response()->json(['message' => 'Hôtel supprimé']);
    }
}
