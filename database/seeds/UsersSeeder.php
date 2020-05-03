<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        App\User::truncate();
        App\RoleUser::truncate();

        $admin = new App\User;
        $admin->id = 1;
        $admin->name = 'Admin';
        $admin->email = 'admin@dotexpress.com';
        $admin->password = Hash::make('admin');
        $admin->created_at = Carbon::now();
        $admin->updated_at = Carbon::now();
        $admin->save();
        $admin->roles()->attach(1);

        $seller = new App\User;
        $seller->id = 2;
        $seller->name = 'Seller';
        $seller->email = 'seller@dotexpress.com';
        $seller->password = Hash::make('seller');
        $seller->created_at = Carbon::now();
        $seller->updated_at = Carbon::now();
        $seller->save();
        $seller->roles()->attach(2);

        $customer = new App\User;
        $customer->id = 3;
        $customer->name = 'Customer';
        $customer->email = 'customer@dotexpress.com';
        $customer->password = Hash::make('customer');
        $customer->created_at = Carbon::now();
        $customer->updated_at = Carbon::now();
        $customer->save();
        $customer->roles()->attach(3);

        Schema::enableForeignKeyConstraints();
    }
}