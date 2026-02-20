<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = InventoryCategory::query();

        if ($request->filled('search')) {
            $q = '%' . mb_strtolower($request->search) . '%';
            $query->whereRaw('LOWER(name) LIKE ?', [$q]);
        }

        $categories = $query->orderBy('name')->paginate(20);

        return view('inventory.index', compact('categories'));
    }

    public function create(): View
    {
        return view('inventory.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'total_lot' => ['nullable', 'integer', 'min:0'],
            'sold_lot' => ['nullable', 'integer', 'min:0'],
        ]);

        InventoryCategory::create([
            'name' => $validated['name'],
            'total_lot' => (int) ($validated['total_lot'] ?? 0),
            'sold_lot' => (int) ($validated['sold_lot'] ?? 0),
        ]);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item added successfully.');
    }

    public function edit(InventoryCategory $inventory): View
    {
        return view('inventory.edit', compact('inventory'));
    }

    public function update(Request $request, InventoryCategory $inventory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'total_lot' => ['required', 'integer', 'min:0'],
            'sold_lot' => ['required', 'integer', 'min:0'],
        ]);

        $inventory->update([
            'name' => $validated['name'],
            'total_lot' => (int) $validated['total_lot'],
            'sold_lot' => (int) $validated['sold_lot'],
        ]);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item updated successfully.');
    }
}
