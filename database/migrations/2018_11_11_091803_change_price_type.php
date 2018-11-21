<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePriceType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('carts', function($table){
        $table->float('price')->change();
      });
      Schema::table('posts', function($table){
        $table->float('price')->change();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('carts', function($table){
        $table->dropColumn('price');
      });
      Schema::table('posts', function($table){
        $table->dropColumn('price');
      });
    }
}
