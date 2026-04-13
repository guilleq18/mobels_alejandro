<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;
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
            ['value' => 'Diseno, fabricacion y colocacion', 'label' => 'una sola coordinacion para resolver el proyecto completo'],
            ['value' => 'Melamina + herreria', 'label' => 'combinaciones firmes para muebles durables y de presencia tecnica'],
            ['value' => $categories->count().' lineas', 'label' => 'para hogar, oficina y espacios comerciales'],
        ];

        $advantages = [
            'Relevamos medidas, definimos distribucion y proponemos soluciones realistas para el uso diario.',
            'Trabajamos terminaciones limpias, herrajes confiables y combinaciones de color alineadas al ambiente.',
            'Cada mueble se piensa para ordenar, resistir y verse profesional una vez instalado.',
        ];

        $serviceHighlights = [
            [
                'title' => 'Cocinas funcionales',
                'copy' => 'Bajo mesadas, alacenas, torres y resoluciones a medida para aprovechar mejor cada pared.',
            ],
            [
                'title' => 'Placares y dormitorios',
                'copy' => 'Interiores ordenados, guardado inteligente y frentes que elevan la presencia del ambiente.',
            ],
            [
                'title' => 'Oficinas y locales',
                'copy' => 'Puestos de trabajo, escritorios, recepciones y mobiliario con una imagen mas tecnica y prolija.',
            ],
        ];

        $workflow = [
            [
                'step' => '01',
                'title' => 'Relevamiento y objetivo',
                'copy' => 'Definimos medidas, uso del ambiente, estilo visual y prioridades reales del proyecto.',
            ],
            [
                'step' => '02',
                'title' => 'Propuesta y materiales',
                'copy' => 'Te mostramos alternativas de distribucion, melaminas, estructura y terminaciones.',
            ],
            [
                'step' => '03',
                'title' => 'Fabricacion cuidada',
                'copy' => 'Producimos con foco en encastres, herrajes y detalles que sostengan el uso cotidiano.',
            ],
            [
                'step' => '04',
                'title' => 'Entrega e instalacion',
                'copy' => 'Coordinamos la colocacion para que el resultado final quede limpio, firme y listo para usar.',
            ],
        ];

        $heroBannerUrl = StoreSetting::assetUrl('home_hero_image_path', 'assets/brand/hero-workshop.svg');

        return view('home', compact(
            'advantages',
            'categories',
            'featuredProducts',
            'heroBannerUrl',
            'metrics',
            'serviceHighlights',
            'workflow',
        ));
    }
}
