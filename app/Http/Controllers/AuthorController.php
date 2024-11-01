<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Models\Country;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search ?? '';
        $countries = Country::all();

        $authors = Author::query()
            ->with('country:id,country',
            'books:id,title,description,publisher,release_date,pages')
            ->orderBy('created_at','desc')
            ->filter(request()->only('search'))
            ->paginate(5)
            ->withQueryString()
            ->through(fn($author) => [
                'id' => $author->id,
                'name' => $author->name,
                'last_name' => $author->last_name,
                'country' => $author->country ?? null,
                'books' =>  $author->books ?? null
            ]);
        
        return inertia('Authors/Index',[
            'authors' => $authors,
            'searchTerm' => $search,
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        // validate
        $data = $request->validated();
        // store
        Author::create($data);
        // redirect
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        // validate
        $data = $request->validated();
        // update
        $author->update($data);
        // redirect
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return back();
    }
}
