<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_employee = Role::where('name', 'employee')->first();
       $role_manager  = Role::where('name', 'admin')->first();
       $role_hr = Role::where('name', 'hr')->first();

       $employee = new User();
       $employee->name = 'Employee Name';
       $employee->email = 'employee@example.com';
       $employee->password = bcrypt('123456');
       $employee->email_verified = 1;
       $employee->save();
       $employee->roles()->attach($role_employee);

       $hr = new User();
       $hr->name = 'Hr Name';
       $hr->email = 'hr@example.com';
       $hr->password = bcrypt('123456');
       $hr->email_verified = 1;
       $hr->save();
       $hr->roles()->attach($role_hr);

       $manager = new User();
       $manager->name = 'Admin Name';
       $manager->email = 'admin@example.com';
       $manager->password = bcrypt('123456');
       $manager->email_verified = 1;
       $manager->save();
       $manager->roles()->attach($role_manager);
       // attach: add role
       //detach : remove role
    }
}
