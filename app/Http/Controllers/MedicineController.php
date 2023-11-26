<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Filters\MedicineFilter;
use App\Http\Resources\MedicineResource;
use App\Http\Resources\MedicineCollection;
use App\Http\Requests\StoreMedicineRequest;

class MedicineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return MedicineCollection
     */
    public function index(Request $request): MedicineCollection
    {
        $this->authorize('viewAny', Medicine::class);

        $filter = new MedicineFilter();
        $queryItems = $filter->transform($request);

        if (empty($queryItems)) {
            return new MedicineCollection(Medicine::all());
        } else {
            // Apply the filters to the query
            return new MedicineCollection(Medicine::where($queryItems)->get());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMedicineRequest $request
     * @return MedicineResource
     */
    public function store(StoreMedicineRequest $request): MedicineResource
    {
        $this->authorize('create', Medicine::class);

        $validatedData = $request->validated();
        $medicine = Medicine::create($validatedData);

        return new MedicineResource($medicine);
    }
    public function addToFavorites(Request $request, $medicineId)
    {
        $pharmacyId = auth()->user()->id;

        // Check if the medicine is already in favorites
        if (Favorite::where('pharmacy_id', $pharmacyId)->where('medicine_id', $medicineId)->exists()) {
            return response()->json(['message' => 'Medicine is already in favorites']);
        }

        // Add the medicine to favorites
        Favorite::create([
            'pharmacy_id' => $pharmacyId,
            'medicine_id' => $medicineId,
        ]);

        return response()->json(['message' => 'Medicine added to favorites']);
    }
    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        //
    }
}
