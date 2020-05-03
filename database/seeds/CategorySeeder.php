<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        App\Category::truncate();

        $electronics = new App\Category;
        $electronics->name = 'Electronics';
        $electronics->machine_name = 'electronics';
        $electronics->save();
        
        $accessories = new App\Category;
        $accessories->name = 'Accessories';
        $accessories->machine_name = 'accessories';
        $accessories->save();

        $home_appliances = new App\Category;
        $home_appliances->name = 'Home Appliances';
        $home_appliances->machine_name = 'home-appliances';
        $home_appliances->save();

        $gadgets = new App\Category;
        $gadgets->name = 'Gadgets';
        $gadgets->machine_name = 'gadgets';
        $gadgets->save();

        Schema::enableForeignKeyConstraints();
    }
}
