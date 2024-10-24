<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'country_id',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
