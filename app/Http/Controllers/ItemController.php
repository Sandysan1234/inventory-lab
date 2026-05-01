<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['room', 'category']);

        // Filter
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('asset_code', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%")
                    ->orWhere('model', 'like', "%{$q}%")
                    ->orWhere('serial_number', 'like', "%{$q}%");
            });
        }

        $items      = $query->orderBy('room_id')->orderBy('asset_code')->paginate(25)->withQueryString();
        $rooms      = Room::orderBy('code')->get();
        $categories = Category::orderBy('name')->get();

        return view('items.index', compact('items', 'rooms', 'categories'));
    }

    public function create()
    {
        $rooms      = Room::orderBy('code')->get();
        $categories = Category::orderBy('name')->get();
        return view('items.create', compact('rooms', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'room_id'        => 'required|exists:rooms,id',
            'category_id'    => 'required|exists:categories,id',
            'brand'          => 'nullable|string|max:100',
            'model'          => 'nullable|string|max:100',
            'serial_number'  => 'nullable|string|max:100',
            'year_purchased' => 'nullable|integer|min:1990|max:' . date('Y'),
            'purchase_price' => 'nullable|numeric|min:0',
            'cpu'            => 'nullable|string|max:200',
            'ram'            => 'nullable|string|max:100',
            'storage'        => 'nullable|string|max:100',
            'os'             => 'nullable|string|max:100',
            'ip_address'     => 'nullable|ip',
            'mac_address'    => 'nullable|string|max:17',
            'specs'          => 'nullable|array',
            'specs.*.key'    => 'nullable|string',
            'specs.*.value'  => 'nullable|string',
            'condition'      => 'required|in:baik,rusak_ringan,rusak_berat,tidak_berfungsi',
            'status'         => 'required|in:aktif,perbaikan,penghapusan,dipinjam',
            'notes'          => 'nullable|string',
            'last_checked'   => 'nullable|date',
        ]);

        // Process dynamic specs into key-value object
        if (!empty($validated['specs'])) {
            $specs = [];
            foreach ($validated['specs'] as $s) {
                if (!empty($s['key'])) {
                    $specs[$s['key']] = $s['value'] ?? '';
                }
            }
            $validated['specs'] = empty($specs) ? null : $specs;
        }

        $validated['asset_code'] = Item::generateAssetCode($validated['room_id'], $validated['category_id']);

        Item::create($validated);

        return redirect()->route('items.index')
                         ->with('success', 'Inventaris berhasil ditambahkan dengan kode aset: ' . $validated['asset_code']);
    }

    public function show(Item $item)
    {
        $item->load(['room', 'category', 'maintenanceLogs' => fn($q) => $q->latest()]);
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $rooms      = Room::orderBy('code')->get();
        $categories = Category::orderBy('name')->get();
        return view('items.edit', compact('item', 'rooms', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'room_id'        => 'required|exists:rooms,id',
            'category_id'    => 'required|exists:categories,id',
            'brand'          => 'nullable|string|max:100',
            'model'          => 'nullable|string|max:100',
            'serial_number'  => 'nullable|string|max:100',
            'year_purchased' => 'nullable|integer|min:1990|max:' . date('Y'),
            'purchase_price' => 'nullable|numeric|min:0',
            'cpu'            => 'nullable|string|max:200',
            'ram'            => 'nullable|string|max:100',
            'storage'        => 'nullable|string|max:100',
            'os'             => 'nullable|string|max:100',
            'ip_address'     => 'nullable|ip',
            'mac_address'    => 'nullable|string|max:17',
            'specs'          => 'nullable|array',
            'specs.*.key'    => 'nullable|string',
            'specs.*.value'  => 'nullable|string',
            'condition'      => 'required|in:baik,rusak_ringan,rusak_berat,tidak_berfungsi',
            'status'         => 'required|in:aktif,perbaikan,penghapusan,dipinjam',
            'notes'          => 'nullable|string',
            'last_checked'   => 'nullable|date',
        ]);

        if (!empty($validated['specs'])) {
            $specs = [];
            foreach ($validated['specs'] as $s) {
                if (!empty($s['key'])) {
                    $specs[$s['key']] = $s['value'] ?? '';
                }
            }
            $validated['specs'] = empty($specs) ? null : $specs;
        }

        $item->update($validated);

        return redirect()->route('items.show', $item)
                         ->with('success', 'Data inventaris berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')
                         ->with('success', 'Inventaris berhasil dihapus.');
    }
}
