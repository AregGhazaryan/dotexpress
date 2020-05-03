<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        \App\Product::truncate();
        
        factory(\App\Product::class, 100)->create();

        Schema::enableForeignKeyConstraints();
    }
}
