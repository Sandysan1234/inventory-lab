<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Category;
use App\Models\Item;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ──────────────────────────────────────────────
        $cats = [
            ['name'=>'PC/Komputer',      'icon'=>'bi-pc-display',       'description'=>'Unit PC dan komputer desktop'],
            ['name'=>'Monitor',           'icon'=>'bi-display',          'description'=>'Layar monitor'],
            ['name'=>'Keyboard',          'icon'=>'bi-keyboard',         'description'=>'Keyboard komputer'],
            ['name'=>'Mouse',             'icon'=>'bi-mouse',            'description'=>'Mouse komputer'],
            ['name'=>'Switch',            'icon'=>'bi-hdd-network',      'description'=>'Network switch'],
            ['name'=>'Access Point',      'icon'=>'bi-wifi',             'description'=>'Wireless access point'],
            ['name'=>'AC/Pendingin',      'icon'=>'bi-thermometer-snow', 'description'=>'Air conditioner / kipas angin'],
            ['name'=>'Papan Tulis',       'icon'=>'bi-easel',            'description'=>'Whiteboard / blackboard'],
            ['name'=>'Meja',              'icon'=>'bi-table',            'description'=>'Meja belajar / kerja'],
            ['name'=>'Kursi',             'icon'=>'bi-person-workspace', 'description'=>'Kursi belajar'],
            ['name'=>'Proyektor',         'icon'=>'bi-projector',        'description'=>'LCD Proyektor'],
            ['name'=>'Printer',           'icon'=>'bi-printer',          'description'=>'Printer'],
            ['name'=>'UPS',               'icon'=>'bi-battery-charging', 'description'=>'Uninterruptible Power Supply'],
            ['name'=>'Lain-lain',         'icon'=>'bi-box',              'description'=>'Peralatan lainnya'],
        ];

        foreach ($cats as $c) {
            Category::create($c);
        }

        // ── Rooms: 7 Lab Informatika ─────────────────────────────────
        for ($i = 1; $i <= 7; $i++) {
            Room::create([
                'code'        => "LAB-{$i}",
                'name'        => "Laboratorium Informatika {$i}",
                'type'        => 'lab_informatika',
                'capacity'    => 40,
                'location'    => "Gedung A Lantai " . ($i <= 3 ? '1' : ($i <= 5 ? '2' : '3')),
                'description' => "Lab komputer untuk mata kuliah pemrograman dan jaringan.",
            ]);
        }

        // ── Rooms: 3 Ruangan Lain ────────────────────────────────────
        $otherRooms = [
            ['code'=>'R-ADM', 'name'=>'Ruang Administrasi Prodi',  'location'=>'Gedung B Lantai 1'],
            ['code'=>'R-DOS', 'name'=>'Ruang Dosen Informatika',   'location'=>'Gedung B Lantai 2'],
            ['code'=>'R-SRV', 'name'=>'Ruang Server / Data Center','location'=>'Gedung A Lantai 1'],
        ];
        foreach ($otherRooms as $r) {
            Room::create(array_merge($r, ['type'=>'ruangan_lain']));
        }

        // ── Sample items for LAB-1 ────────────────────────────────────
        $lab1    = Room::where('code','LAB-1')->first();
        $pcCat   = Category::where('name','PC/Komputer')->first();
        $monCat  = Category::where('name','Monitor')->first();
        $swCat   = Category::where('name','Switch')->first();
        $apCat   = Category::where('name','Access Point')->first();
        $acCat   = Category::where('name','AC/Pendingin')->first();
        $pbCat   = Category::where('name','Papan Tulis')->first();

        // 5 sample PCs
        for ($n = 1; $n <= 5; $n++) {
            Item::create([
                'asset_code'    => "LAB-1-PC-" . str_pad($n, 3, '0', STR_PAD_LEFT),
                'name'          => "PC Laboratorium 1 Unit {$n}",
                'room_id'       => $lab1->id,
                'category_id'   => $pcCat->id,
                'brand'         => 'ASUS',
                'model'         => 'ExpertCenter D500TC',
                'serial_number' => 'SN2024' . str_pad($n, 4, '0', STR_PAD_LEFT),
                'year_purchased'=> 2023,
                'purchase_price'=> 8500000,
                'cpu'           => 'Intel Core i5-12400',
                'ram'           => '8 GB DDR4',
                'storage'       => '256 GB SSD',
                'os'            => 'Windows 11 Pro',
                'ip_address'    => '192.168.1.' . (10 + $n),
                'mac_address'   => '00:1A:2B:3C:4D:' . str_pad(dechex($n), 2, '0', STR_PAD_LEFT),
                'condition'     => $n == 3 ? 'rusak_ringan' : 'baik',
                'status'        => 'aktif',
                'last_checked'  => now()->subDays(30),
            ]);
        }

        // Switch
        Item::create([
            'asset_code'    => 'LAB-1-SWT-001',
            'name'          => 'Network Switch 24 Port',
            'room_id'       => $lab1->id,
            'category_id'   => $swCat->id,
            'brand'         => 'TP-Link',
            'model'         => 'TL-SG1024D',
            'year_purchased'=> 2022,
            'specs'         => ['Jumlah Port'=>'24', 'Speed'=>'10/100/1000 Mbps'],
            'condition'     => 'baik',
            'status'        => 'aktif',
        ]);

        // Access Point
        Item::create([
            'asset_code'    => 'LAB-1-WAP-001',
            'name'          => 'Wireless Access Point',
            'room_id'       => $lab1->id,
            'category_id'   => $apCat->id,
            'brand'         => 'Ubiquiti',
            'model'         => 'UniFi AP AC Lite',
            'year_purchased'=> 2022,
            'condition'     => 'baik',
            'status'        => 'aktif',
        ]);

        // AC
        Item::create([
            'asset_code'    => 'LAB-1-AC-001',
            'name'          => 'AC Split 2 PK',
            'room_id'       => $lab1->id,
            'category_id'   => $acCat->id,
            'brand'         => 'Daikin',
            'model'         => 'FTKC50NVM',
            'year_purchased'=> 2021,
            'specs'         => ['Kapasitas'=>'2 PK / 18.000 BTU', 'Refrigeran'=>'R32'],
            'condition'     => 'baik',
            'status'        => 'aktif',
        ]);

        // Papan Tulis
        Item::create([
            'asset_code'    => 'LAB-1-PBT-001',
            'name'          => 'Whiteboard 180x90cm',
            'room_id'       => $lab1->id,
            'category_id'   => $pbCat->id,
            'brand'         => 'Deli',
            'specs'         => ['Ukuran'=>'180 x 90 cm'],
            'condition'     => 'baik',
            'status'        => 'aktif',
        ]);
    }
}
