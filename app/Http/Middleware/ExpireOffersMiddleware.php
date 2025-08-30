<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExpireOffersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $expiredOffers = Offer::where('end_date', '<', Carbon::now())->get();

        foreach ($expiredOffers as $offer) {
          // Log::info('ExpireOffersMiddleware ran for offer id: '.$offer->id);
            foreach ($offer->offerProducts as $offerProduct) {
                $product = $offerProduct->product;
                if ($product) {
                    $product->offer_amount = 0;
                    $product->save();
                }
                $offerProduct->delete();
            }
        }

        return $next($request);
    }
}