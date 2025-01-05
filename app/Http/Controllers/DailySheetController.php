<?php

namespace App\Http\Controllers;

use App\Models\DailySheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DailySheetController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:daily_sheets,date',
            'daily_focus' => 'required|string',
            'day_rating' => 'nullable|integer|min:1|max:10',
            'learned_today' => 'nullable|string',
            'priorities' => 'required|array|min:1|max:5',
            'priorities.*.description' => 'required|string',
            'avoid_items' => 'required|array|min:1|max:3',
            'avoid_items.*.description' => 'required|string',
            'gratitude_items' => 'required|array|min:1|max:3',
            'gratitude_items.*.description' => 'required|string',
        ]);

        return DB::transaction(function () use ($validated) {
            $dailySheet = DailySheet::create([
                'date' => $validated['date'],
                'daily_focus' => $validated['daily_focus'],
                'day_rating' => $validated['day_rating'] ?? null,
                'learned_today' => $validated['learned_today'] ?? null,
            ]);

            foreach ($validated['priorities'] as $index => $priority) {
                $dailySheet->priorities()->create([
                    'description' => $priority['description'],
                    'order_number' => $index + 1,
                ]);
            }

            foreach ($validated['avoid_items'] as $index => $item) {
                $dailySheet->avoidItems()->create([
                    'description' => $item['description'],
                    'order_number' => $index + 1,
                ]);
            }

            foreach ($validated['gratitude_items'] as $index => $item) {
                $dailySheet->gratitudeItems()->create([
                    'description' => $item['description'],
                    'order_number' => $index + 1,
                ]);
            }

            return $dailySheet->load(['priorities', 'avoidItems', 'gratitudeItems']);
        });
    }

    public function show(string $date)
    {
        $dailySheet = DailySheet::with(['priorities', 'avoidItems', 'gratitudeItems'])
            ->whereDate('date', $date)
            ->firstOrFail();

        return $dailySheet;
    }

    public function update(Request $request, DailySheet $dailySheet)
    {
        $validated = $request->validate([
            'daily_focus' => 'sometimes|required|string',
            'day_rating' => 'nullable|integer|min:1|max:10',
            'learned_today' => 'nullable|string',
            'priorities' => 'sometimes|required|array|min:1|max:5',
            'priorities.*.description' => 'required|string',
            'avoid_items' => 'sometimes|required|array|min:1|max:3',
            'avoid_items.*.description' => 'required|string',
            'gratitude_items' => 'sometimes|required|array|min:1|max:3',
            'gratitude_items.*.description' => 'required|string',
        ]);

        return DB::transaction(function () use ($dailySheet, $validated) {
            $dailySheet->update([
                'daily_focus' => $validated['daily_focus'] ?? $dailySheet->daily_focus,
                'day_rating' => $validated['day_rating'] ?? $dailySheet->day_rating,
                'learned_today' => $validated['learned_today'] ?? $dailySheet->learned_today,
            ]);

            if (isset($validated['priorities'])) {
                $dailySheet->priorities()->delete();
                foreach ($validated['priorities'] as $index => $priority) {
                    $dailySheet->priorities()->create([
                        'description' => $priority['description'],
                        'order_number' => $index + 1,
                    ]);
                }
            }

            if (isset($validated['avoid_items'])) {
                $dailySheet->avoidItems()->delete();
                foreach ($validated['avoid_items'] as $index => $item) {
                    $dailySheet->avoidItems()->create([
                        'description' => $item['description'],
                        'order_number' => $index + 1,
                    ]);
                }
            }

            if (isset($validated['gratitude_items'])) {
                $dailySheet->gratitudeItems()->delete();
                foreach ($validated['gratitude_items'] as $index => $item) {
                    $dailySheet->gratitudeItems()->create([
                        'description' => $item['description'],
                        'order_number' => $index + 1,
                    ]);
                }
            }

            return $dailySheet->load(['priorities', 'avoidItems', 'gratitudeItems']);
        });
    }
} 