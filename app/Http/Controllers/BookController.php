<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ver el uso de LazyById en la consulta
        // y entregar todos los datos de la tabla de forma directa
        // sin hacer consultas adicionales
        // el filtrado se usaria por primevue


        // filter by search value | more kbs transfer
        // $books = Book::where('title', 'like', "%{$search}%")
        //     ->orWhere('description', 'like', "%{$search}%")
        //     ->orWhere('isbn', 'like', "%{$search}%")
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        $books = Book::query()
        ->select('id','title','pages','isbn','publisher','release_date')
        ->toBase()
        ->lazyById(10000);


        // check for times
        // test with book::where and with a lazyById implementation and with tobase() and lazyById
        // dd(
        //     'Books count:' . $books->count(),
        //     'Memory Taken: ' . round((memory_get_peak_usage(true) / 1024 / 1024), 2) . ' MB',
        //     'Time Taken: ' . round((microtime(true) - LARAVEL_START), 2) . ' seconds',
        //     'Resource cost: ' . round(microtime(2) - LARAVEL_START, 2) * round(memory_get_peak_usage() / 1024 / 1024, 2)
        // );



        return inertia('Books/Index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
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
        return redirect()->route('books.index')->with('success', 'Book created successfully');
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
            'authors' => Author::all(),
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
        // check if image is uploaded
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        // update
        $book->update($data);
        // sync
        $book->authors()->sync($data['authors']);
        $book->categories()->sync($data['categories']);
        // redirect
        return redirect()->route('books.index')->with('success', 'Book updated successfully');
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
