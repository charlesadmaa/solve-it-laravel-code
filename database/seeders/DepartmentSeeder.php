<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departments;


class DepartmentSeeder extends Seeder
{

    public function run(): void
    {
    $departmentList = [
      "Mass Communication",
      "Science lab tech",
      "Political Science",
      "Electrical Engineering",
      "Agricultural Engineering",
    ];

        foreach($departmentList as $item){
            $department = new Departments();
            $department->name = $item;
            $department->save();
        }

    }
}
