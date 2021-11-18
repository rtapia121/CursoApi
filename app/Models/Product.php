<?php

namespace App\Models;

use App\Utils\CanBeRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, CanBeRate;

    protected $guarded = [];

    public function category()
    {
        $this->belongsTo(Category::class);
    }

    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted()
    {
        static::creating(function (Product $product) {
            $faker = \Faker\Factory::create();
            $product->image_url = $faker->imageUrl();
            $product->createBy()->associate(auth()->user());
        });
    }
}
