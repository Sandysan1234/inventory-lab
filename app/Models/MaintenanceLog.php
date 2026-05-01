<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'date', 'type', 'description',
        'technician', 'cost', 'condition_before', 'condition_after',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'pemeliharaan'           => 'Pemeliharaan',
            'perbaikan'              => 'Perbaikan',
            'penggantian_komponen'   => 'Penggantian Komponen',
            'pemeriksaan'            => 'Pemeriksaan',
            default                  => $this->type,
        };
    }

    public function getTypeBadgeClass(): string
    {
        return match($this->type) {
            'pemeliharaan'         => 'bg-info',
            'perbaikan'            => 'bg-warning text-dark',
            'penggantian_komponen' => 'bg-danger',
            'pemeriksaan'          => 'bg-secondary',
            default                => 'bg-light text-dark',
        };
    }
}
