<?php

namespace App\Models;

use App\Utils\CanBeRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, CanBeRate;

    protected $guarded =[];

    public function category(){
        $this->belongsTo(Category::class);
    }

    public function createBy(){
        return $this->belongsTo(User::class);
    }
}
