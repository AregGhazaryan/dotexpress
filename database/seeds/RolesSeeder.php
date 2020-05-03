<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        App\Role::truncate();

        $admin = new App\Role;
        $admin->id = 1;
        $admin->name = 'Admin';
        $admin->machine_name = 'admin';
        $admin->save();

        $seller = new App\Role;
        $seller->id = 2;
        $seller->name = 'Seller';
        $seller->machine_name = 'seller';
        $seller->save();

        $customer = new App\Role;
        $customer->id = 3;
        $customer->name = 'Customer';
        $customer->machine_name = 'customer';
        $customer->save();

        Schema::enableForeignKeyConstraints();
    }
}
