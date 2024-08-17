<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Service\VisitorService;

class VisitorSeeder extends Seeder
{
    use VisitorService;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('visitors')->insert([
            'name' => Str::random(10),
            'lastName' => Str::random(10),
            'status' => 'position',
            'company' => 'Google',
            'phone' => '0123456789',
            'telegram' => '@telegram',
            'email' => Str::random(10).'@example.com',
            'category' => 'cat',
            'code' => $this->createCode(),
        ]);
    }
}
