<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use App\Models\Category;
use App\Models\MaintenanceLog;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems  = Item::count();
        $totalRooms  = Room::count();
        $labRooms    = Room::where('type', 'lab_informatika')->count();

        $byCondition = Item::selectRaw('`condition`, count(*) as total')
            ->groupBy('condition')
            ->pluck('total', 'condition');

        $byStatus = Item::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $byCategory = Category::withCount('items')
            ->orderByDesc('items_count')
            ->get();

        $byRoom = Room::withCount('items')->get();

        $recentMaintenance = MaintenanceLog::with(['item.room'])
            ->latest()
            ->take(5)
            ->get();

        $damagedItems = Item::with(['room', 'category'])
            ->whereIn('condition', ['rusak_berat', 'tidak_berfungsi'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.index', compact(
            'totalItems',
            'totalRooms',
            'labRooms',
            'byCondition',
            'byStatus',
            'byCategory',
            'byRoom',
            'recentMaintenance',
            'damagedItems'
        ));
    }
}
