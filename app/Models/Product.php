<?php

namespace App\Models;

use App\Utils\CanBeRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory, CanBeRate;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function createdBy()
    {
        // return $this->belongsTo(User::class, 'created_by');
        return $this->belongsTo(User::class,'id');
    }

    protected static function booted()
    {
        static::creating(function (Product $product) {
            $faker = \Faker\Factory::create();
            $product->image_url = $faker->imageUrl();
            $product->createdBy()->associate(auth()->user());
        });
    }
}
