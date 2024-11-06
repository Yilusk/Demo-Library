<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index(){
        $books = Book::query()
        ->orderBy('created_at','desc')
        ->select('id','image','title')
        ->paginate(14);


        return inertia('Home/Index',[
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'books' => $books
        ]);
    }

    public function searchView(){

        $search = request()->search ?? '';

        $books = Book::query()
        ->orderBy('created_at','desc')
        ->with('authors:id,name,last_name')
        ->filter(request()->only('search'))
        ->select('id','title','publisher','release_date','image','language','volumen')
        ->paginate(3)
        ->withQueryString()
        ->through(fn($book) => [
            'id' => $book->id,
            'title' => $book->title,
            'publisher' => $book->publisher,
            'release_date' => $book->release_date,
            'image' => $book->image,
            'language' => $book->language,
            'volumen' => $book->volumen,
            'authors' => $book->authors ?? null,
        ]);


        return inertia('Home/Search',[
            'searchTerm' => $search,
            'books' => $books,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function showDetail(Book $book){
        return inertia('Home/Show',[
            'book' => $book,
            'authors' => $book->authors,
            'categories' => $book->categories,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }



}
