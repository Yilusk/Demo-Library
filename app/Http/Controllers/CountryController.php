<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

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

    public function store(StoreCountryRequest $request)
    {
        // validate
        $data = $request->validated();
        // store
        Country::create($data);
        // redirect
        return back();
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        // validate
        $data = $request->validated();
        // update
        $country->update($data);
        // redirect
        return back();
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return back();
    }
}
