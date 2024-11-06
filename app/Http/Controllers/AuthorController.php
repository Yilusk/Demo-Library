<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Models\Country;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $search = request()->search ?? '';
        $countries = Country::all();

        $authors = Author::query()
            ->with('country:id,country',
            'books:id,title,publisher,release_date,pages,language,volumen')
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

    public function store(StoreAuthorRequest $request)
    {
        // validate
        $data = $request->validated();
        // store
        Author::create($data);
        // redirect
        return back();
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        // validate
        $data = $request->validated();
        // update
        $author->update($data);
        // redirect
        return back();
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return back();
    }
}
