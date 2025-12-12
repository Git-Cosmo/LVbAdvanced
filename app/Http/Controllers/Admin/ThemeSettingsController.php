<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteTheme;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThemeSettingsController extends Controller
{
    public function index()
    {
        $themes = SiteTheme::orderByDesc('priority')
            ->orderByDesc('start_date')
            ->paginate(20);

        $activeTheme = SiteTheme::getActiveTheme();

        return view('admin.themes.index', [
            'themes' => $themes,
            'activeTheme' => $activeTheme,
            'page' => (object) ['title' => 'Theme Settings'],
        ]);
    }

    public function create()
    {
        return view('admin.themes.create', [
            'page' => (object) ['title' => 'Create Theme'],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:site_themes,slug',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'priority' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            
            // Visual effects
            'enable_snow' => 'boolean',
            'enable_lights' => 'boolean',
            'enable_confetti' => 'boolean',
            'enable_fireworks' => 'boolean',
            'snow_intensity' => 'nullable|string',
            'lights_color' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Build effects JSON
        $effects = [
            'snow' => [
                'enabled' => $request->boolean('enable_snow'),
                'intensity' => $request->input('snow_intensity', 'medium'),
            ],
            'lights' => [
                'enabled' => $request->boolean('enable_lights'),
                'color' => $request->input('lights_color', 'multicolor'),
            ],
            'confetti' => [
                'enabled' => $request->boolean('enable_confetti'),
            ],
            'fireworks' => [
                'enabled' => $request->boolean('enable_fireworks'),
            ],
        ];

        SiteTheme::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'effects' => $effects,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'priority' => $validated['priority'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.themes.index')
            ->with('success', 'Theme created successfully!');
    }

    public function edit(SiteTheme $theme)
    {
        return view('admin.themes.edit', [
            'theme' => $theme,
            'page' => (object) ['title' => 'Edit Theme'],
        ]);
    }

    public function update(Request $request, SiteTheme $theme)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:site_themes,slug,' . $theme->id,
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'priority' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Build effects JSON
        $effects = [
            'snow' => [
                'enabled' => $request->boolean('enable_snow'),
                'intensity' => $request->input('snow_intensity', 'medium'),
            ],
            'lights' => [
                'enabled' => $request->boolean('enable_lights'),
                'color' => $request->input('lights_color', 'multicolor'),
            ],
            'confetti' => [
                'enabled' => $request->boolean('enable_confetti'),
            ],
            'fireworks' => [
                'enabled' => $request->boolean('enable_fireworks'),
            ],
        ];

        $theme->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? $theme->slug,
            'description' => $validated['description'] ?? null,
            'effects' => $effects,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'priority' => $validated['priority'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.themes.index')
            ->with('success', 'Theme updated successfully!');
    }

    public function destroy(SiteTheme $theme)
    {
        $theme->delete();

        return redirect()->route('admin.themes.index')
            ->with('success', 'Theme deleted successfully!');
    }

    public function toggle(SiteTheme $theme)
    {
        $theme->update(['is_active' => !$theme->is_active]);

        return back()->with('success', 'Theme status updated!');
    }
}
