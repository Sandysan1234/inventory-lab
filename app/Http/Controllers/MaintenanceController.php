<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MaintenanceLog;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceLog::with(['item.room', 'item.category'])->latest('date');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $logs = $query->paginate(20)->withQueryString();
        return view('maintenance.index', compact('logs'));
    }

    public function create(Item $item)
    {
        return view('maintenance.create', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        $validated = $request->validate([
            'date'              => 'required|date',
            'type'              => 'required|in:pemeliharaan,perbaikan,penggantian_komponen,pemeriksaan',
            'description'       => 'required|string',
            'technician'        => 'nullable|string|max:100',
            'cost'              => 'nullable|numeric|min:0',
            'condition_before'  => 'required|in:baik,rusak_ringan,rusak_berat,tidak_berfungsi',
            'condition_after'   => 'required|in:baik,rusak_ringan,rusak_berat,tidak_berfungsi',
        ]);

        $validated['item_id'] = $item->id;
        MaintenanceLog::create($validated);

        // Update item condition & last checked
        $item->update([
            'condition'    => $validated['condition_after'],
            'last_checked' => $validated['date'],
        ]);

        return redirect()->route('items.show', $item)
                         ->with('success', 'Log pemeliharaan berhasil dicatat.');
    }

    public function destroy(MaintenanceLog $maintenanceLog)
    {
        $item = $maintenanceLog->item;
        $maintenanceLog->delete();
        return redirect()->route('items.show', $item)
                         ->with('success', 'Log pemeliharaan berhasil dihapus.');
    }
}
