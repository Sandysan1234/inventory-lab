<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'type', 'capacity', 'location', 'description'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'lab_informatika' => 'Lab Informatika',
            'ruangan_lain'    => 'Ruangan Lain',
            default           => $this->type,
        };
    }

    public function getTypeBadgeClass(): string
    {
        return match($this->type) {
            'lab_informatika' => 'bg-primary',
            'ruangan_lain'    => 'bg-secondary',
            default           => 'bg-light text-dark',
        };
    }

    public function getTotalItems(): int
    {
        return $this->items()->count();
    }

    public function getItemsByCondition(): array
    {
        return $this->items()
            ->selectRaw('`condition`, count(*) as total')
            ->groupBy('condition')
            ->pluck('total', 'condition')
            ->toArray();
    }
}
