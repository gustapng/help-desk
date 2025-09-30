<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TicketPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('ticket_priorities')->insert([
            ['name' => 'low', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'medium', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'high', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
