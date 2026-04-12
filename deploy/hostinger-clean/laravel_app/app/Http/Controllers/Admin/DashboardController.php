<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\QuoteRequest;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            [
                'label' => 'Categorias',
                'value' => Category::query()->count(),
                'hint' => 'Lineas activas para organizar el catalogo.',
            ],
            [
                'label' => 'Productos activos',
                'value' => Product::query()->active()->count(),
                'hint' => 'Items visibles hoy en la tienda publica.',
            ],
            [
                'label' => 'Presupuestos',
                'value' => QuoteRequest::query()->count(),
                'hint' => 'Consultas recibidas desde fichas de producto.',
            ],
            [
                'label' => 'Pendientes',
                'value' => QuoteRequest::query()->where('status', 'pending')->count(),
                'hint' => 'Solicitudes que todavia esperan seguimiento.',
            ],
        ];

        $recentProducts = Product::query()
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        $recentQuotes = QuoteRequest::query()
            ->with('product.category')
            ->latest()
            ->take(6)
            ->get();

        $recentCategories = Category::query()
            ->withCount('products')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'recentCategories',
            'recentProducts',
            'recentQuotes',
            'stats',
        ));
    }
}
