<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search ?? '';

        $countries = Country::query()
            ->orderBy('country')
            ->filter(request()->only('search'))
            ->paginate(3)
            ->withQueryString()
            ->through(fn($country) => [
                'id' => $country->id,
                'country' => $country->country
            ]);

        return inertia('Countries/Index', [
            'countries' => $countries,
            'searchTerm' => $search,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCountryRequest $request)
    {
        // validate
        $data = $request->validated();
        // store
        Country::create($data);
        // redirect
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        // validate
        $data = $request->validated();
        // update
        $country->update($data);
        // redirect
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return back();
    }
}
