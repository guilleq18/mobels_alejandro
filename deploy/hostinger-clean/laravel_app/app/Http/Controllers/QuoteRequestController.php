<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class QuoteRequestController extends Controller
{
    public function store(StoreQuoteRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $product->quoteRequests()->create($request->validated());

        return redirect()
            ->to(route('products.show', $product).'#presupuesto')
            ->with('quote_request_created', 'Tu consulta ya quedó registrada. MÖBELS Alejandro puede seguir desde aquí o por el canal que indicaste.');
    }
}
