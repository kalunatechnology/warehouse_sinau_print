<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse;
use App\Models\Unit;
use App\Models\Material;
use App\Models\Machine;
use App\Models\Transaction;
use App\Models\MachineCounter;
use App\Models\User;
use Carbon\Carbon;

class DashboardDataSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Clearing existing data...');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('machine_counter_logs')->delete();
        DB::table('machine_counters')->delete();
        DB::table('transactions')->delete();
        DB::table('machines')->delete();
        DB::table('materials')->delete();
        DB::table('units')->delete();
        DB::table('warehouses')->delete();
        
        DB::statement('ALTER TABLE machine_counter_logs AUTO_INCREMENT = 1;');
        DB::statement('ALTER TABLE machine_counters AUTO_INCREMENT = 1;');
        DB::statement('ALTER TABLE transactions AUTO_INCREMENT = 1;');
        DB::statement('ALTER TABLE machines AUTO_INCREMENT = 1;');
        DB::statement('ALTER TABLE materials AUTO_INCREMENT = 1;');
        DB::statement('ALTER TABLE units AUTO_INCREMENT = 1;');
        DB::statement('ALTER TABLE warehouses AUTO_INCREMENT = 1;');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Creating warehouses...');
        $warehouses = [
            ['branch_name' => 'Jakarta Pusat', 'wh_type' => 'Gudang Barang', 'wh_name' => 'Gudang Bahan Printing Jakarta'],
            ['branch_name' => 'Surabaya', 'wh_type' => 'Gudang Barang', 'wh_name' => 'Gudang Bahan Printing Surabaya'],
            ['branch_name' => 'Bandung', 'wh_type' => 'Gudang Jasa', 'wh_name' => 'Workshop Digital Printing Bandung'],
            ['branch_name' => 'Semarang', 'wh_type' => 'Gudang Barang', 'wh_name' => 'Gudang Regional Semarang'],
            ['branch_name' => 'Yogyakarta', 'wh_type' => 'Gudang Jasa', 'wh_name' => 'Service Center Yogyakarta'],
        ];

        $createdWarehouses = [];
        foreach ($warehouses as $warehouse) {
            $createdWarehouses[] = Warehouse::create($warehouse);
        }

        $this->command->info('Creating units...');
        $units = [
            ['u_name' => 'Roll'],
            ['u_name' => 'Sheet'],
            ['u_name' => 'Liter'],
            ['u_name' => 'Pcs'],
            ['u_name' => 'Box'],
            ['u_name' => 'Pack'],
            ['u_name' => 'Meter'],
            ['u_name' => 'Kg'],
            ['u_name' => 'Botol'],
            ['u_name' => 'Rim'],
        ];

        $createdUnits = [];
        foreach ($units as $unit) {
            $createdUnits[] = Unit::create($unit);
        }

        $this->command->info('Creating materials...');
        $materials = [
            [
                'm_code' => 'TNT001',
                'm_name' => 'Tinta Sublimation Cyan 1L',
                'm_price' => 120000,
                'm_type' => 'Tinta Digital',
                'm_supplier' => 'PT. Ink Technology Indonesia',
                'unit' => $createdUnits[8]->id,
                'unit_detail' => 'Botol 1L',
                'conversion' => 1.00,
                'm_limit' => 20,
                'waste' => 2.0
            ],
            [
                'm_code' => 'TNT002',
                'm_name' => 'Tinta Sublimation Magenta 1L',
                'm_price' => 120000,
                'm_type' => 'Tinta Digital',
                'm_supplier' => 'PT. Ink Technology Indonesia',
                'unit' => $createdUnits[8]->id,
                'unit_detail' => 'Botol 1L',
                'conversion' => 1.00,
                'm_limit' => 20,
                'waste' => 2.0
            ],
            [
                'm_code' => 'TNT003',
                'm_name' => 'Tinta Sublimation Yellow 1L',
                'm_price' => 120000,
                'm_type' => 'Tinta Digital',
                'm_supplier' => 'PT. Ink Technology Indonesia',
                'unit' => $createdUnits[8]->id,
                'unit_detail' => 'Botol 1L',
                'conversion' => 1.00,
                'm_limit' => 20,
                'waste' => 2.0
            ],
            [
                'm_code' => 'TNT004',
                'm_name' => 'Tinta Sublimation Black 1L',
                'm_price' => 125000,
                'm_type' => 'Tinta Digital',
                'm_supplier' => 'PT. Ink Technology Indonesia',
                'unit' => $createdUnits[8]->id,
                'unit_detail' => 'Botol 1L',
                'conversion' => 1.00,
                'm_limit' => 25,
                'waste' => 2.0
            ],
            
            [
                'm_code' => 'MED001',
                'm_name' => 'MMT Banner 340gsm',
                'm_price' => 8500,
                'm_type' => 'Media Outdoor',
                'm_supplier' => 'CV. Media Digital Indonesia',
                'unit' => $createdUnits[6]->id,
                'unit_detail' => 'Lebar 1.37m',
                'conversion' => 1.37,
                'm_limit' => 100,
                'waste' => 5.0
            ],
            [
                'm_code' => 'MED002',
                'm_name' => 'Vinyl Sticker Glossy',
                'm_price' => 12000,
                'm_type' => 'Media Indoor',
                'm_supplier' => 'PT. Vinyl Nusantara',
                'unit' => $createdUnits[6]->id,
                'unit_detail' => 'Lebar 1.22m',
                'conversion' => 1.22,
                'm_limit' => 50,
                'waste' => 3.0
            ],
            [
                'm_code' => 'MED003',
                'm_name' => 'Flexy China 280gsm',
                'm_price' => 6500,
                'm_type' => 'Media Outdoor',
                'm_supplier' => 'CV. Media Digital Indonesia',
                'unit' => $createdUnits[6]->id,
                'unit_detail' => 'Lebar 1.5m',
                'conversion' => 1.50,
                'm_limit' => 150,
                'waste' => 4.0
            ],
            [
                'm_code' => 'MED004',
                'm_name' => 'Photo Paper Glossy A4',
                'm_price' => 85000,
                'm_type' => 'Media Indoor',
                'm_supplier' => 'PT. Paper Indonesia',
                'unit' => $createdUnits[5]->id,
                'unit_detail' => 'Pack 100 Sheet',
                'conversion' => 100.00,
                'm_limit' => 50,
                'waste' => 1.0
            ],
            [
                'm_code' => 'MED005',
                'm_name' => 'Kain Spunbond untuk Printing',
                'm_price' => 15000,
                'm_type' => 'Media Tekstil',
                'm_supplier' => 'CV. Tekstil Digital',
                'unit' => $createdUnits[6]->id,
                'unit_detail' => 'Lebar 1.5m',
                'conversion' => 1.50,
                'm_limit' => 80,
                'waste' => 3.5
            ],
            
            [
                'm_code' => 'KRT001',
                'm_name' => 'Kertas HVS A4 80gsm',
                'm_price' => 55000,
                'm_type' => 'Kertas',
                'm_supplier' => 'PT. Kertas Indonesia',
                'unit' => $createdUnits[9]->id,
                'unit_detail' => 'Rim 500 Sheet',
                'conversion' => 500.00,
                'm_limit' => 100,
                'waste' => 0.5
            ],
            [
                'm_code' => 'KRT002',
                'm_name' => 'Kertas Art Paper 150gsm A4',
                'm_price' => 75000,
                'm_type' => 'Kertas',
                'm_supplier' => 'PT. Art Paper Indonesia',
                'unit' => $createdUnits[9]->id,
                'unit_detail' => 'Rim 250 Sheet',
                'conversion' => 250.00,
                'm_limit' => 80,
                'waste' => 1.0
            ],
            [
                'm_code' => 'AMP001',
                'm_name' => 'Amplop Putih 80gsm 10x23cm',
                'm_price' => 450,
                'm_type' => 'Amplop',
                'm_supplier' => 'CV. Amplop Nusantara',
                'unit' => $createdUnits[3]->id,
                'unit_detail' => 'Per Lembar',
                'conversion' => 1.00,
                'm_limit' => 5000,
                'waste' => 0.2
            ],
            [
                'm_code' => 'AMP002',
                'm_name' => 'Amplop Coklat A4 Manila',
                'm_price' => 850,
                'm_type' => 'Amplop',
                'm_supplier' => 'CV. Amplop Nusantara',
                'unit' => $createdUnits[3]->id,
                'unit_detail' => 'Per Lembar',
                'conversion' => 1.00,
                'm_limit' => 3000,
                'waste' => 0.3
            ],
            
            [
                'm_code' => 'BHN001',
                'm_name' => 'Lem Spray Mounting',
                'm_price' => 45000,
                'm_type' => 'Bahan Pendukung',
                'm_supplier' => 'PT. Chemical Indonesia',
                'unit' => $createdUnits[8]->id,
                'unit_detail' => 'Spray 400ml',
                'conversion' => 0.40,
                'm_limit' => 30,
                'waste' => 1.5
            ],
            [
                'm_code' => 'BHN002',
                'm_name' => 'Double Tape 24mm',
                'm_price' => 25000,
                'm_type' => 'Bahan Pendukung',
                'm_supplier' => 'CV. Tape Indonesia',
                'unit' => $createdUnits[0]->id,
                'unit_detail' => 'Roll 50m',
                'conversion' => 50.00,
                'm_limit' => 50,
                'waste' => 2.0
            ],
            [
                'm_code' => 'BHN003',
                'm_name' => 'Foam Board 5mm 70x100cm',
                'm_price' => 18000,
                'm_type' => 'Bahan Pendukung',
                'm_supplier' => 'PT. Foam Indonesia',
                'unit' => $createdUnits[1]->id,
                'unit_detail' => 'Sheet 70x100cm',
                'conversion' => 1.00,
                'm_limit' => 100,
                'waste' => 3.0
            ]
        ];

        $createdMaterials = [];
        foreach ($materials as $material) {
            $createdMaterials[] = Material::create($material);
        }

        $this->command->info('Creating machines...');
        $machines = [
            [
                'wh_id' => $createdWarehouses[0]->id,
                'code' => 'PRN001',
                'name' => 'Printer Digital Epson SureColor S40600',
                'type' => 'Large Format Printer',
                'location' => 'Area Produksi Digital',
                'status' => 'active'
            ],
            [
                'wh_id' => $createdWarehouses[0]->id,
                'code' => 'PRN002',
                'name' => 'Printer Roland VersaCAMM VS-640i',
                'type' => 'Print & Cut Machine',
                'location' => 'Area Produksi Digital',
                'status' => 'active'
            ],
            [
                'wh_id' => $createdWarehouses[1]->id,
                'code' => 'PRN003',
                'name' => 'Printer HP Latex 315',
                'type' => 'Latex Printer',
                'location' => 'Area Produksi Latex',
                'status' => 'maintenance'
            ],
            [
                'wh_id' => $createdWarehouses[0]->id,
                'code' => 'CUT001',
                'name' => 'Mesin Cutting Plotter Graphtec CE7000',
                'type' => 'Cutting Plotter',
                'location' => 'Area Finishing',
                'status' => 'active'
            ],
            [
                'wh_id' => $createdWarehouses[1]->id,
                'code' => 'LAM001',
                'name' => 'Mesin Laminating Roll to Roll',
                'type' => 'Laminating Machine',
                'location' => 'Area Finishing',
                'status' => 'broken'
            ],
            [
                'wh_id' => $createdWarehouses[2]->id,
                'code' => 'PRN004',
                'name' => 'Printer Sublimasi Epson F570',
                'type' => 'Sublimation Printer',
                'location' => 'Workshop Sublimasi',
                'status' => 'active'
            ]
        ];

        $createdMachines = [];
        foreach ($machines as $machine) {
            $createdMachines[] = Machine::create($machine);
        }

        $user = User::first();
        if (!$user) {
            $this->command->error('No user found! Please create a user first.');
            return;
        }
        $userId = $user->id;

        $this->command->info('Creating transactions...');
        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now();

        for ($i = 0; $i < 300; $i++) {
            $randomDate = Carbon::createFromTimestamp(
                rand($startDate->timestamp, $endDate->timestamp)
            );

            $transactionType = rand(1, 10) <= 7 ? 1 : 0;

            $materialIndex = rand(0, count($createdMaterials) - 1);
            $warehouseIndex = rand(0, count($createdWarehouses) - 1);
            
            $qtyRange = $this->getQtyRange($materialIndex + 1);
            
            Transaction::create([
                'wh_id' => $createdWarehouses[$warehouseIndex]->id,
                'm_id' => $createdMaterials[$materialIndex]->id,
                'qty' => rand($qtyRange['min'], $qtyRange['max']),
                'type' => $transactionType,
                'price' => $this->getMaterialPrice($materialIndex + 1),
                'user_id' => $userId,
                'created_at' => $randomDate,
                'updated_at' => $randomDate
            ]);
        }

        $this->command->info('Creating machine counters...');
        foreach ($createdMachines as $index => $machine) {
            $baseCounter = rand(5000, 15000);
            
            for ($i = 0; $i < 60; $i++) {
                $recordDate = Carbon::now()->subDays(60 - $i);
                
                $increment = $this->getCounterIncrement($index + 1);
                
                MachineCounter::create([
                    'machine_id' => $machine->id,
                    'counter' => $baseCounter + ($i * $increment),
                    'recorded_at' => $recordDate,
                    'created_at' => $recordDate,
                    'updated_at' => $recordDate
                ]);
            }
        }

        $this->command->info('Seeding completed successfully!');
        $this->command->info('Created:');
        $this->command->info('- ' . count($createdWarehouses) . ' warehouses');
        $this->command->info('- ' . count($createdUnits) . ' units');
        $this->command->info('- ' . count($createdMaterials) . ' materials');
        $this->command->info('- ' . count($createdMachines) . ' machines');
        $this->command->info('- 300 transactions');
        $this->command->info('- ' . (count($createdMachines) * 60) . ' machine counter readings');
    }

    private function getQtyRange($materialId)
    {
        if ($materialId >= 1 && $materialId <= 4) {
            return ['min' => 1, 'max' => 10];
        }
        if ($materialId >= 5 && $materialId <= 9) {
            return ['min' => 10, 'max' => 100];
        }
        if ($materialId >= 10 && $materialId <= 11) {
            return ['min' => 5, 'max' => 50];
        }
        if ($materialId >= 12 && $materialId <= 13) {
            return ['min' => 100, 'max' => 5000];
        }
        return ['min' => 1, 'max' => 50];
    }

    private function getMaterialPrice($materialId)
    {
        $prices = [
            1 => 120000, 2 => 120000, 3 => 120000, 4 => 125000,
            5 => 8500, 6 => 12000, 7 => 6500, 8 => 85000, 9 => 15000,
            10 => 55000, 11 => 75000,
            12 => 450, 13 => 850,
            14 => 45000, 15 => 25000, 16 => 18000
        ];
        
        return $prices[$materialId] ?? 50000;
    }

    private function getCounterIncrement($machineId)
    {
        $increments = [
            1 => rand(50, 150),
            2 => rand(30, 100),
            3 => rand(40, 120),
            4 => rand(20, 80),
            5 => rand(10, 50),
            6 => rand(60, 180)
        ];
        
        return $increments[$machineId] ?? 50;
    }
}