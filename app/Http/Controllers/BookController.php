<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = request()->search ?? '';
        $books = Book::query()
        ->orderBy('created_at','desc')
        ->with('authors:id,name,last_name', 'categories')
        ->filter($request->only('search'))
        ->paginate(3)
        ->withQueryString()
        ->through(fn($book) => [
            'id' => $book->id,
            'title' => $book->title,
            'publisher' => $book->publisher,
            'release_date' => $book->release_date,
            'authors' => $book->authors ?? null,
            'categories' => $book->categories ?? null
        ]);
        

        return inertia('Books/Index', [
            'books' => $books,
            'searchTerm' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::select('id', 'name', 'last_name')->get();
        $categories = Category::all();
        return inertia('Books/Create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        // validate
        $data = $request->validated();

        // check if image is uploaded
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        // store
        $book = Book::create($data);

        // sync
        $book->authors()->sync($data['authors']);
        $book->categories()->sync($data['categories']);

        // redirect
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return inertia('Books/Show', [
            'book' => $book,
            'authors' => $book->authors,
            'categories' => $book->categories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return inertia('Books/Edit', [
            'authors' => Author::select('id', 'name', 'last_name')->get(),
            'categories' => Category::all(),
            'book' => $book,
            'authorsOfBook' => $book->authors,
            'categoriesOfBook' => $book->categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        // validate
        $data = $request->validated();

        // mantain image
        $data['image'] = $book->image;

        
        // check if image is uploaded
        if ($request->file('image')) {
            // delete old image
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }


        // update
        $book->update($data);
        // sync
        $book->authors()->sync($data['authors']);
        $book->categories()->sync($data['categories']);


        // redirect
        return to_route('books.edit', $book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book Deleted');
    }
}
