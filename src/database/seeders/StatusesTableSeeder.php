<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'id'         => 1,
                'name'      => 'Open',
            ],
            [
                'id'         => 2,
                'name'      => 'Processing',
            ],
            
            [
                'id'         => 3,
                'name'      => 'Completed',
            ],
        ];

        Status::insert($statuses);
    }
}
