<?php

namespace App\Http\Controllers\Inertia;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rate'       => 'required|integer|between:1,5',
            'comment'    => 'required|string|min:5|max:500',
        ]);

        $user = Auth::guard('web')->user();

        // One review per product per user
        $existing = Comment::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            return response()->json(['message' => __('flash.product_already_reviewed')], 422);
        }

        Comment::create([
            'user_id'    => $user->id,
            'product_id' => $request->product_id,
            'rate'       => $request->rate,
            'comment'    => $request->comment,
        ]);

        return response()->json(['message' => __('flash.review_added_success')]);
    }

    public function index($productId)
    {
        $reviews = Comment::where('product_id', $productId)
            ->with('user:id,first_name,family_name')
            ->latest()
            ->get()
            ->map(fn($r) => [
                'id'         => $r->id,
                'rate'       => $r->rate,
                'comment'    => $r->comment,
                'created_at' => $r->created_at->diffForHumans(),
                'user_name'  => ($r->user->first_name ?? '') . ' ' . ($r->user->family_name ?? ''),
            ]);

        $avg = $reviews->avg('rate');
        $count = $reviews->count();

        return response()->json(compact('reviews', 'avg', 'count'));
    }
}
