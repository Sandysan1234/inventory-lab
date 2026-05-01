<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_code', 'name', 'room_id', 'category_id',
        'brand', 'model', 'serial_number',
        'year_purchased', 'purchase_price',
        'cpu', 'ram', 'storage', 'os', 'ip_address', 'mac_address',
        'specs', 'condition', 'status', 'notes', 'last_checked',
    ];

    protected $casts = [
        'specs'        => 'array',
        'last_checked' => 'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }

    // ---------- Label helpers ----------

    public function getConditionLabel(): string
    {
        return match($this->condition) {
            'baik'           => 'Baik',
            'rusak_ringan'   => 'Rusak Ringan',
            'rusak_berat'    => 'Rusak Berat',
            'tidak_berfungsi'=> 'Tidak Berfungsi',
            default          => $this->condition,
        };
    }

    public function getConditionBadgeClass(): string
    {
        return match($this->condition) {
            'baik'           => 'bg-success',
            'rusak_ringan'   => 'bg-warning text-dark',
            'rusak_berat'    => 'bg-danger',
            'tidak_berfungsi'=> 'bg-dark',
            default          => 'bg-secondary',
        };
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'aktif'       => 'Aktif',
            'perbaikan'   => 'Dalam Perbaikan',
            'penghapusan' => 'Penghapusan',
            'dipinjam'    => 'Dipinjam',
            default       => $this->status,
        };
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'aktif'       => 'bg-success',
            'perbaikan'   => 'bg-warning text-dark',
            'penghapusan' => 'bg-danger',
            'dipinjam'    => 'bg-info',
            default       => 'bg-secondary',
        };
    }

    // ---------- Asset code generator ----------

    public static function generateAssetCode(int $roomId, int $categoryId): string
    {
        $room     = Room::find($roomId);
        $category = Category::find($categoryId);
        $prefix   = strtoupper(substr($room->code ?? 'XX', 0, 5));
        $catCode  = strtoupper(substr(preg_replace('/\s+/', '', $category->name ?? 'XX'), 0, 3));
        $seq      = str_pad(
            self::where('room_id', $roomId)->where('category_id', $categoryId)->count() + 1,
            3, '0', STR_PAD_LEFT
        );
        return "{$prefix}-{$catCode}-{$seq}";
    }
}
