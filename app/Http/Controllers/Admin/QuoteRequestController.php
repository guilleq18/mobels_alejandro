<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    public function index(): View
    {
        $quoteRequests = QuoteRequest::query()
            ->with('product.category')
            ->latest()
            ->get();

        return view('admin.quote-requests.index', compact('quoteRequests'));
    }
}
