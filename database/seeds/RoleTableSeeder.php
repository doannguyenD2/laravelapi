<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_employee = new Role();
       $role_employee->name = 'employee';
       $role_employee->description = 'Employee';
       $role_employee->save();

       $role_employee = new Role();
       $role_employee->name = 'hr';
       $role_employee->description = 'Human recruiter';
       $role_employee->save();

       $role_manager = new Role();
       $role_manager->name = 'admin';
       $role_manager->description = 'Admin';
       $role_manager->save();
    }
}
