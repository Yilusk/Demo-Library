<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\AuthorFactory;
use Database\Factories\BookFactory;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'alex',
            'email' => 'admin@admin.com',
        ]);

        AuthorFactory::new()
            ->count(5)
            ->create()
            ->each(function ($author) {
                $books = BookFactory::new()
                    ->count(random_int(1, 5))
                    ->create()
                    ->each(function ($book) {
                        $category = CategoryFactory::new()->create();
                        $book->categories()->attach($category);
                    });

                $author->books()
                    ->attach($books);
            });
    }
}
