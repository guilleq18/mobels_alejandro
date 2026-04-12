<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $categories = Category::query()
            ->featured()
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::query()
            ->with(['category', 'colorVariants.galleryImages'])
            ->active()
            ->featured()
            ->orderBy('price')
            ->get();

        $metrics = [
            ['value' => '100%', 'label' => 'melamina premium y terminaciones limpias'],
            ['value' => '15 dias', 'label' => 'para primeras entregas coordinadas'],
            ['value' => $categories->count(), 'label' => 'lineas iniciales para hogar y oficina'],
        ];

        $advantages = [
            'Disenamos piezas modulares que aprovechan mejor cada centimetro.',
            'Trabajamos con melaminas resistentes, herrajes confiables y armado prolijo.',
            'La tienda queda lista para evolucionar hacia carrito, pagos y panel administrativo.',
        ];

        $heroBanner = 'assets/brand/hero-workshop.svg';

        return view('home', compact(
            'advantages',
            'categories',
            'featuredProducts',
            'heroBanner',
            'metrics',
        ));
    }
}
