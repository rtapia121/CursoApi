<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\RatingResource;
use App\Models\Product;
use App\Models\Rating;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductRatingController extends Controller
{
    public function rate(Product $product, Request $request)
    {
        $this->validate($request, [
            'score' => 'required'
        ]);

        // dd($request->user(), Auth::user());
        /** @var User $user */
        $user = $request->user();
        $user->rate($product, $request->get('score'), $request->get('comments'));
        return new ProductResource($product);
    }

    public function unrate(Product $product, Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->unrate($product);

        return new ProductResource($product);
    }

    public function approve( Rating $rating){
        Gate::authorize('admin',$rating);
        $rating->approve();
        $rating->save();

        return response()->json(200);
    }

    public function list(Request $request){
        Gate::authorize('admin');
        $builder = Rating::query()
        ->when($request->has('approved'), function($query){
            return $query->whereNotNull('approved_at');
        })->when($request->has('not_approved'), function($query){
            return $query->whereNull('approved_at');
        });

        return RatingResource::collection($builder->get());
    }
}
