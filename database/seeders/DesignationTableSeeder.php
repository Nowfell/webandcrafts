<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Designation::insert([
            ['name' => 'Trainee engineer'],
            ['name' => 'Software engineer'],
            ['name' => 'Senior software engineer'],
            ['name' => 'Principal software engineer'],
            ['name' => 'Team leader'],
            ['name' => 'Project leader'],
            ['name' => 'Staff engineer'],
            ['name' => 'Project manager'],
        ]);
    }
}
