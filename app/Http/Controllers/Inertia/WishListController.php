<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WishListController extends Controller
{
    public function addProductToWishList($id, Request $request)
    {
        $user = Auth::guard('web')->user();
        $productId = $id;
        if (Auth::guard('web')->check()) {
            if ($user->wishlistProducts()->where('product_id', $productId)->exists()) {
                $user->wishlistProducts()->detach($productId);
                return response()->json([
                    'success' => true,
                    'background' => '#ffd5d5',
                    'message' => translateWithHTMLTags('Product removed from your favourites'),
                ]);
            } else {
                $user->wishlistProducts()->attach($productId);
                return response()->json([
                    'success' => true,
                    'background' => '#F55157',
                    'message' => translateWithHTMLTags('Product added to your favourites'),
                ]);
            }
        } else {
            // Guest user logic
            $guestId = $this->getGuestId($request);
            $guest = Guest::find($guestId);
//            dd($guest);
            if ($guest->wishlistProducts()->where('product_id', $productId)->exists()) {
                $guest->wishlistProducts()->detach($productId);
                return response()->json([
                    'success' => true,
                    'background' => '#ffd5d5',
                ]);
            } else {
                $guest->wishlistProducts()->attach($productId);
                return response()->json([
                    'success' => true,
                    'background' => '#F55157',
                ]);
            }
        }
    }

    private function getGuestId(Request $request)
    {
        $cookieId = $request->cookie('guest_id');
        if (!$cookieId) {
            $cookieId = (string)Str::uuid();
            cookie()->queue('guest_id', $cookieId, 60 * 24 * 30); // Store guest_id for 30 days
        }

        $guest = Guest::firstOrCreate(['cookie_id' => $cookieId]);

        return $guest->id; // Return the auto-incrementing guest_id
    }

    public function wishListInProductDetails($id, Request $request)
    {
        $user = Auth::guard('web')->user();
        $productId = $id;
        if (Auth::guard('web')->check()) {
            if ($user->wishlistProducts()->where('product_id', $productId)->exists()) {
                $user->wishlistProducts()->detach($productId);
                return back()->with('danger', 'تم ازالة المنتج في المفضله');
            } else {
                $user->wishlistProducts()->attach($productId);
                return back()->with('success', 'تم اضافة المنتج في المفضله');
            }
        } else {
            // Guest user logic
            $guestId = $this->getGuestId($request);
            $guest = Guest::firstOrCreate(['id' => $guestId]);

            if ($guest->wishlistProducts()->where('product_id', $productId)->exists()) {
                $guest->wishlistProducts()->detach($productId);
                return back()->with('danger', 'تم ازالة المنتج في المفضله');
            } else {
                $guest->wishlistProducts()->attach($productId);
                return back()->with('success', 'تم اضافة المنتج في المفضله');
            }
        }
    }
}
