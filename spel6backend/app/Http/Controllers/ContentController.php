<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    /**
     * Return all content fields for a given page.
     */
    public function show(string $page): JsonResponse
    {
        $entries = Content::query()
            ->where('page', $page)
            ->orderBy('field')
            ->get();

        return response()->json([
            'page' => $page,
            'fields' => $entries
                ->mapWithKeys(fn (Content $entry) => [
                    $entry->field => [
                        'id' => $entry->id,
                        'page' => $entry->page,
                        'field' => $entry->field,
                        'type' => $entry->type,
                        'value' => $entry->value,
                    ],
                ])
                ->toArray(),
            'items' => $entries,
        ]);
    }
}
