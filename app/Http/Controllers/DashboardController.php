<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::count();
        $authors = Author::count();
        $categories = Category::count();
        $author_books_count = Author::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(5)
            ->get();

        return inertia('Dashboard', [
            'books' => $books,
            'authors' => $authors,
            'categories' => $categories,
            'author_books_count' => $author_books_count
        ]);
    }
}
