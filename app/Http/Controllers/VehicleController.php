<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $allowedFilters = [
            'brand',
            'model',
            'color',
            'year',
            'price'
        ];

         $query = Vehicle::query();

        foreach ($allowedFilters as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        
        return response()->json($query->get(), 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'year' => 'required|integer|min:1886',
            'price' => 'required|numeric|min:0',
        ]);

        $vehicle = Vehicle::create($validated);

        return response()->json($vehicle, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return response()->json($vehicle, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
          $validated = $request->validate([
            'brand' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
            'color' => 'sometimes|required|string|max:100',
            'year' => 'sometimes|required|integer|min:1886',
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        $vehicle->update($validated);

        return response()->json($vehicle, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->noContent();
    }
}