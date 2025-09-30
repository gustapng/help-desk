<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('ticket_types')->insert([
            ['name' => 'technical_problem', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'service_request', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'support_question', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'improvement_suggestion', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'security_incident', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'other', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
