<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    // LISTE DES HÔTELS avec URL complète pour l'image
    public function index()
    {
        $hotels = Hotel::all()->map(function ($hotel) {
            return [
                'id' => $hotel->id,
                'nom' => $hotel->nom,
                'adresse' => $hotel->adresse,
                'prix' => $hotel->prix,
                'image' => $hotel->image ? asset('storage/' . $hotel->image) : null,
            ];
        });

        return response()->json($hotels);
    }

    // CRÉER UN HÔTEL avec  image
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048', 
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('hotels', 'public');
        }

        $hotel = Hotel::create($validated);

        
        $hotel->image = $hotel->image ? asset('storage/' . $hotel->image) : null;

        return response()->json($hotel, 201);
    }

    // AFFICHER UN HÔTEL
    public function show(Hotel $hotel)
    {
        $hotel->image = $hotel->image ? asset('storage/' . $hotel->image) : null;
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

        if ($request->hasFile('image')) {
            if ($hotel->image) {
                Storage::disk('public')->delete($hotel->image);
            }
            $validated['image'] = $request->file('image')->store('hotels', 'public');
        }

        $hotel->update($validated);

        $hotel->image = $hotel->image ? asset('storage/' . $hotel->image) : null;

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
