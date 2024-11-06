<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $search = request()->search ?? '';

        $categories = Category::query()
            ->orderBy('created_at','desc')
            ->filter(request()->only('search'))
            ->paginate(3)
            ->withQueryString()
            ->through(fn($category) => [
                'id' => $category->id,
                'category' => $category->category
            ]);

        return inertia('Categories/Index', [
            'categories' => $categories,
            'searchTerm' => $search
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        // validate
        $data = $request->validated();
        // store
        Category::create($data);
        // redirect
        return back();
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // validate
        $data = $request->validated();
        // update
        $category->update($data);
        // redirect
        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
