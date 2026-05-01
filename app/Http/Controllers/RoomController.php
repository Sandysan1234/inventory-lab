<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::withCount('items')->orderBy('type')->orderBy('code')->get();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:20|unique:rooms,code',
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:lab_informatika,ruangan_lain',
            'capacity'    => 'nullable|integer|min:1',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function show(Room $room)
    {
        $items = $room->items()
            ->with('category')
            ->orderBy('category_id')
            ->orderBy('asset_code')
            ->paginate(20);

        $byCondition = $room->getItemsByCondition();

        return view('rooms.show', compact('room', 'items', 'byCondition'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:20|unique:rooms,code,' . $room->id,
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:lab_informatika,ruangan_lain',
            'capacity'    => 'nullable|integer|min:1',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.show', $room)
            ->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        if ($room->items()->count() > 0) {
            return back()->with('error', 'Ruangan tidak dapat dihapus karena masih memiliki inventaris.');
        }

        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Ruangan berhasil dihapus.');
    }
}
