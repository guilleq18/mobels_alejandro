<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'alejandro@example.com'],
            [
                'name' => 'Alejandro Demo',
                'password' => Hash::make('password'),
            ],
        );

        $categories = collect([
            [
                'name' => 'Cocinas',
                'slug' => 'cocinas',
                'description' => 'Modulos superiores, alacenas y bajo mesadas pensados para resistir el uso diario.',
                'is_featured' => true,
            ],
            [
                'name' => 'Dormitorios',
                'slug' => 'dormitorios',
                'description' => 'Placares, mesas de luz y respaldos con almacenaje inteligente.',
                'is_featured' => true,
            ],
            [
                'name' => 'Oficinas',
                'slug' => 'oficinas',
                'description' => 'Escritorios, bibliotecas y estaciones de trabajo para espacios productivos.',
                'is_featured' => true,
            ],
            [
                'name' => 'Living',
                'slug' => 'living',
                'description' => 'Racks, vajilleros y muebles modulares para exhibir y guardar.',
                'is_featured' => true,
            ],
        ])->mapWithKeys(function (array $category): array {
            $model = Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category,
            );

            return [$category['slug'] => $model];
        });

        $products = [
            [
                'category' => 'cocinas',
                'name' => 'Cocina Modular Alba',
                'slug' => 'cocina-modular-alba',
                'sku' => 'COC-ALBA-001',
                'short_description' => 'Combinacion de roble claro y blanco mate para cocinas luminosas.',
                'description' => 'Incluye bajo mesada, torre de horno y alacenas con herrajes de cierre suave.',
                'price' => 1250000,
                'stock' => 3,
                'lead_time_days' => 7,
                'is_active' => true,
                'is_featured' => true,
                'variants' => [
                    ['name' => 'Blanco Patagonia', 'hex' => '#F3EFE8'],
                    ['name' => 'Roble Siena', 'hex' => '#B88B64'],
                ],
            ],
            [
                'category' => 'dormitorios',
                'name' => 'Placard Andes',
                'slug' => 'placard-andes',
                'sku' => 'DOR-ANDES-001',
                'short_description' => 'Placard de tres puertas con interiores modulables.',
                'description' => 'Integra barrales, cajonera central y baulera superior para optimizar guardado.',
                'price' => 890000,
                'stock' => 4,
                'lead_time_days' => 7,
                'is_active' => true,
                'is_featured' => true,
                'variants' => [
                    ['name' => 'Lino Arena', 'hex' => '#D8D5CE'],
                    ['name' => 'Nogal Andino', 'hex' => '#6B5948'],
                ],
            ],
            [
                'category' => 'oficinas',
                'name' => 'Escritorio Nativo',
                'slug' => 'escritorio-nativo',
                'sku' => 'OFI-NATIVO-001',
                'short_description' => 'Superficie amplia con modulo lateral para archivos y CPU.',
                'description' => 'Ideal para home office con pasacables ocultos y tapa de 36 mm reforzada.',
                'price' => 480000,
                'stock' => 8,
                'lead_time_days' => 7,
                'is_active' => true,
                'is_featured' => true,
                'variants' => [
                    ['name' => 'Tortora Tecnico', 'hex' => '#D1C4B0'],
                    ['name' => 'Petroleo Urbano', 'hex' => '#4A5E73'],
                ],
            ],
            [
                'category' => 'living',
                'name' => 'Rack Terra',
                'slug' => 'rack-terra',
                'sku' => 'LIV-TERRA-001',
                'short_description' => 'Rack para TV con puertas corredizas y nichos abiertos.',
                'description' => 'Pensado para televisores grandes, consolas y organizacion de cables.',
                'price' => 540000,
                'stock' => 6,
                'lead_time_days' => 7,
                'is_active' => true,
                'is_featured' => true,
                'variants' => [
                    ['name' => 'Vison Calido', 'hex' => '#CDBDAA'],
                    ['name' => 'Tabaco Terra', 'hex' => '#7A5A43'],
                ],
            ],
        ];

        foreach ($products as $product) {
            $model = Product::query()->updateOrCreate(
                ['slug' => $product['slug']],
                [
                    'category_id' => $categories[$product['category']]->id,
                    'name' => $product['name'],
                    'sku' => $product['sku'],
                    'short_description' => $product['short_description'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'lead_time_days' => $product['lead_time_days'],
                    'is_active' => $product['is_active'],
                    'is_featured' => $product['is_featured'],
                ],
            );

            $model->colorVariants()->delete();

            foreach ($product['variants'] as $variantIndex => $variant) {
                $colorVariant = $model->colorVariants()->create([
                    'name' => $variant['name'],
                    'slug' => Str::slug($variant['name']),
                    'hex_color' => $variant['hex'],
                    'swatch_image_path' => $this->buildSeedSwatch($variant['name'], $variant['hex']),
                    'sort_order' => $variantIndex,
                ]);

                foreach ($this->buildSeedGallery($model->name, $variant['name'], $variant['hex']) as $imageIndex => $imageUrl) {
                    $colorVariant->galleryImages()->create([
                        'image_path' => $imageUrl,
                        'alt_text' => $model->name.' en '.$variant['name'],
                        'sort_order' => $imageIndex,
                    ]);
                }
            }
        }
    }

    private function buildSeedSwatch(string $variantName, string $hexColor): string
    {
        $accent = $this->adjustColor($hexColor, -18);
        $light = $this->adjustColor($hexColor, 18);
        $label = Str::upper($variantName);

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 240" role="img" aria-label="{$variantName}">
  <defs>
    <linearGradient id="swatch" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{$light}"/>
      <stop offset="100%" stop-color="{$hexColor}"/>
    </linearGradient>
  </defs>
  <rect width="240" height="240" rx="28" fill="url(#swatch)"/>
  <rect x="24" y="40" width="192" height="18" rx="9" fill="{$accent}" opacity="0.18"/>
  <rect x="24" y="94" width="192" height="12" rx="6" fill="{$accent}" opacity="0.12"/>
  <rect x="24" y="132" width="192" height="20" rx="10" fill="{$accent}" opacity="0.1"/>
  <rect x="24" y="184" width="128" height="16" rx="8" fill="rgba(24,33,43,0.12)"/>
  <text x="24" y="214" fill="#18212B" font-size="16" font-family="Montserrat, Arial, sans-serif" font-weight="700">{$label}</text>
</svg>
SVG;

        return 'data:image/svg+xml;charset=UTF-8,'.rawurlencode($svg);
    }

    private function buildSeedGallery(string $productName, string $variantName, string $hexColor): array
    {
        return collect([
            ['scene' => 'frente', 'title' => 'Vista frontal'],
            ['scene' => 'detalle', 'title' => 'Detalle de terminacion'],
            ['scene' => 'ambiente', 'title' => 'Vista en ambiente'],
        ])->map(function (array $scene, int $index) use ($productName, $variantName, $hexColor): string {
            $accent = $this->adjustColor($hexColor, $index * -14);
            $neutral = $this->adjustColor($hexColor, 22);
            $shadow = $this->adjustColor($hexColor, -26);

            $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 900" role="img" aria-label="{$productName} {$variantName} {$scene['title']}">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#F4F2EE"/>
      <stop offset="50%" stop-color="{$neutral}"/>
      <stop offset="100%" stop-color="#EEF3F5"/>
    </linearGradient>
    <linearGradient id="panel" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{$hexColor}"/>
      <stop offset="100%" stop-color="{$accent}"/>
    </linearGradient>
  </defs>
  <rect width="1200" height="900" rx="48" fill="url(#bg)"/>
  <circle cx="1020" cy="160" r="140" fill="{$neutral}" opacity="0.4"/>
  <circle cx="180" cy="760" r="180" fill="{$accent}" opacity="0.15"/>
  <rect x="92" y="86" width="1016" height="728" rx="36" fill="rgba(255,255,255,0.55)" stroke="rgba(24,33,43,0.08)"/>
  <rect x="170" y="220" width="860" height="420" rx="30" fill="url(#panel)" opacity="0.18"/>
  <rect x="218" y="278" width="764" height="308" rx="26" fill="rgba(255,255,255,0.78)" stroke="rgba(24,33,43,0.12)"/>
  <rect x="260" y="320" width="680" height="224" rx="20" fill="{$hexColor}" opacity="0.92"/>
  <rect x="260" y="320" width="680" height="36" rx="18" fill="{$shadow}" opacity="0.18"/>
  <rect x="308" y="368" width="180" height="128" rx="16" fill="rgba(255,255,255,0.35)"/>
  <rect x="518" y="368" width="180" height="128" rx="16" fill="rgba(255,255,255,0.28)"/>
  <rect x="728" y="368" width="164" height="128" rx="16" fill="rgba(24,33,43,0.12)"/>
  <rect x="248" y="566" width="704" height="22" rx="11" fill="{$shadow}" opacity="0.18"/>
  <text x="170" y="154" fill="#202F5B" font-size="34" font-family="Montserrat, Arial, sans-serif" font-weight="700">MÖBELS ALEJANDRO</text>
  <text x="170" y="192" fill="#4F8191" font-size="22" font-family="Manrope, Arial, sans-serif">{$productName} · {$variantName} · {$scene['title']}</text>
  <text x="170" y="734" fill="#18212B" font-size="46" font-family="Montserrat, Arial, sans-serif" font-weight="700">Melamina premium</text>
  <text x="170" y="778" fill="#60707D" font-size="24" font-family="Manrope, Arial, sans-serif">Disponible en 7 dias · Herrajes seleccionados · Color {$variantName}</text>
</svg>
SVG;

            return 'data:image/svg+xml;charset=UTF-8,'.rawurlencode($svg);
        })->all();
    }

    private function adjustColor(string $hexColor, int $delta): string
    {
        $hexColor = ltrim($hexColor, '#');

        [$red, $green, $blue] = [
            hexdec(substr($hexColor, 0, 2)),
            hexdec(substr($hexColor, 2, 2)),
            hexdec(substr($hexColor, 4, 2)),
        ];

        $channel = static fn (int $value): int => max(0, min(255, $value));

        return sprintf(
            '#%02X%02X%02X',
            $channel($red + $delta),
            $channel($green + $delta),
            $channel($blue + $delta),
        );
    }
}
