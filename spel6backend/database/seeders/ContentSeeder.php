<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Seed demo content for the marketing pages.
     */
    public function run(): void
    {
        $records = [
            [
                'page' => 'home',
                'field' => 'hero_title',
                'type' => 'text',
                'value' => 'Welkom bij Spel6',
            ],
            [
                'page' => 'home',
                'field' => 'hero_subtitle',
                'type' => 'text',
                'value' => 'Bouw razendsnel marketingpagina\'s met configureerbare blokken.',
            ],
            [
                'page' => 'home',
                'field' => 'hero_cta_text',
                'type' => 'text',
                'value' => 'Plan een demo',
            ],
            [
                'page' => 'home',
                'field' => 'hero_cta_link',
                'type' => 'link',
                'value' => '/contact',
            ],
            [
                'page' => 'home',
                'field' => 'intro_paragraph',
                'type' => 'text',
                'value' => 'Alle content op deze pagina komt uit de content-tabel, zodat de front-end enkel hoeft te renderen.',
            ],
            [
                'page' => 'home',
                'field' => 'hero_image',
                'type' => 'image',
                'value' => 'https://images.unsplash.com/photo-1522199710521-72d69614c702?auto=format&fit=crop&w=1200&q=60',
            ],
        ];

        foreach ($records as $record) {
            Content::query()->updateOrCreate(
                [
                    'page' => $record['page'],
                    'field' => $record['field'],
                ],
                $record
            );
        }
    }
}
