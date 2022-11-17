<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warehouses')->insert([
            [
                'warehouse_code' => 1,
                'warehouse_name' => 'Nam Khánh',
                'warehouse_street' => 'HP',
                'warehouse_contact' => '0123456789',
                'warehouse_note' => '',
                'warehouse_status' => 1,
            ],
            [
                'warehouse_code' => 2,
                'warehouse_name' => 'Kho 1',
                'warehouse_street' => 'HP',
                'warehouse_contact' => '0123456789',
                'warehouse_note' => '',
                'warehouse_status' => 1,
            ]
        ]);
        DB::table('categories')->insert([
            [
                'category_code' => 1,
                'category_name' => 'Nội thất',
                'category_note' => '',
                'category_status' => 1,
            ],
            [
                'category_code' => 2,
                'category_name' => 'Ngoại thất',
                'category_note' => '',
                'category_status' => 1,
            ],
            [
                'category_code' => 3,
                'category_name' => 'Vật tư phụ',
                'category_note' => '',
                'category_status' => 1,
            ],
            [
                'category_code' => 4,
                'category_name' => 'Phụ kiện ô tô',
                'category_note' => '',
                'category_status' => 1,
            ],
            [
                'category_code' => 5,
                'category_name' => 'Toyota Vios',
                'category_note' => '',
                'category_status' => 1,
            ],
            [
                'category_code' => 6,
                'category_name' => 'KIA Morning',
                'category_note' => '',
                'category_status' => 1,
            ],
            [
                'category_code' => 7,
                'category_name' => 'Vật tư sơn',
                'category_note' => '',
                'category_status' => 1,
            ],
            [
                'category_code' => 8,
                'category_name' => 'Phụ tùng thân vỏ',
                'category_note' => 'Thuộc về phần thân ngoài của xe',
                'category_status' => 1,
            ],
            [
                'category_code' => 9,
                'category_name' => 'Điện, máy gầm',
                'category_note' => '',
                'category_status' => 1,
            ]
        ]);
        // DB::table('units')->insert([
        //     [
        //         'unit_amount' => 1,
        //         'unit_name' => 'Cái',

        //     ],
        //     [
        //         'unit_amount' => 2,
        //         'unit_name' => 'Can',
        //     ]
        // ]);
        DB::table('suppliers')->insert([
            [
                'supplier_code' => 1,
                'supplier_name' => 'An Thịnh',
                'supplier_phone' => '0123456789',
                'supplier_codetax' => '0123456789',
                'supplier_status' => 1,
            ],
            [
                'supplier_code' => 2,
                'supplier_name' => 'Thịnh Phát',
                'supplier_phone' => '0123456789',
                'supplier_codetax' => '0123456789',
                'supplier_status' => 1,
            ]
        ]);
        DB::table('shelves')->insert([
            [
                'shelf_code' => 1,
                'shelf_name' => 'Kệ 1',
                'shelf_position' => 'HP',
                'shelf_note' => '',
                'shelf_status' => 1,
            ],
            [
                'shelf_code' => 2,
                'shelf_name' => 'Kệ 2',
                'shelf_position' => 'HP',
                'shelf_note' => '',
                'shelf_status' => 1,
            ]
        ]);
        DB::table('warehouse_details')->insert([
            [
                'warehouse_id' => 1,
                'shelf_id' => 1,
            ],
            [
                'warehouse_id' => 2,
                'shelf_id' => 2,
            ]
        ]);
        DB::table('warehouse_managers')->insert([
            [
                'warehouse_id' => 1,
                'user_id' => 1,
            ],
            [
                'warehouse_id' => 2,
                'user_id' => 1,
            ],
            [
                'warehouse_id' => 1,
                'user_id' => 2,
            ],
            [
                'warehouse_id' => 2,
                'user_id' => 2,
            ],
            [
                'warehouse_id' => 1,
                'user_id' => 3,
            ],
            [
                'warehouse_id' => 2,
                'user_id' => 3,
            ],
        ]);
        // DB::table('items')->insert([
        //     [
        //         'item_name' => 'Bánh xe',
        //         'item_code' => rand(100000, 999999),
        //         'item_unit' => 1,
        //         'category_id' => 2,
        //         'item_status' => 1,
        //     ],
        //     [
        //         'item_name' => 'Bánh lái',
        //         'item_code' => rand(100000, 999999),
        //         'item_unit' => 1,
        //         'category_id' => 1,
        //         'item_status' => 1,
        //     ]
        // ]);
        // DB::table('item_details')->insert([
        //     [
        //         'item_id' => 1,
        //         'warehouse_id' => 1,
        //         'supplier_id' => 1,
        //         'shelf_id' => 1,
        //         'floor_id' => 1,
        //         'cell_id' => 1,
        //         'item_quantity' => 20
        //     ],
        //     [
        //         'item_id' => 1,
        //         'warehouse_id' => 1,
        //         'supplier_id' => 1,
        //         'shelf_id' => 1,
        //         'floor_id' => 1,
        //         'cell_id' => 2,
        //         'item_quantity' => 25
        //     ],
        //     [
        //         'item_id' => 2,
        //         'warehouse_id' => 1,
        //         'supplier_id' => 2,
        //         'shelf_id' => 2,
        //         'floor_id' => 4,
        //         'cell_id' => 10,
        //         'item_quantity' => 23
        //     ],
        //     [
        //         'item_id' => 1,
        //         'warehouse_id' => 1,
        //         'supplier_id' => 1,
        //         'shelf_id' => 2,
        //         'floor_id' => 4,
        //         'cell_id' => 24,
        //         'item_quantity' => 26
        //     ]
        // ]);
        // DB::table('unit_details')->insert([
        //     [
        //         'unit_id' => 1,
        //         'item_id' => 1,
        //     ],
        //     [
        //         'unit_id' => 2,
        //         'item_id' => 2,
        //     ]
        // ]);
    }
}
