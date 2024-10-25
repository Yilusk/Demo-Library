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
    public function index(Request $request)
    {
        $search = $request->input('search','');
        $countries = Country::all();

        $authors = Author::where('first_name','like',"%{$search}%")
            ->orWhere('last_name','like',"%{$search}%")
            ->with('country:id,country', 'books:title')
            ->paginate(10);

        return inertia('Authors/Index');
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
    public function store(StoreAuthorRequest $request)
    {
        // validate
        $data = $request->validated();
        // store
        Author::create($data);
        // redirect
        return redirect()->route('authors.index')->with('success', 'Author created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
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
        return redirect()->route('authors.index')->with('success', 'Author updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('authors.index');
    }
}
