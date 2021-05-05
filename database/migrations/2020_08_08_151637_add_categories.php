<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('categories')->insert(array(
            'name' => 'Travel',
            'icon' => '🌍'
        ));

        DB::table('categories')->insert(array(
            'name' => 'Music',
            'icon' => '🎵'
        ));

        DB::table('categories')->insert(array(
            'name' => 'Movie',
            'icon' => '🎬'
        ));

        DB::table('categories')->insert(array(
            'name' => 'Reading',
            'icon' => '📖'
        ));

        DB::table('categories')->insert(array(
            'name' => 'Gaming',
            'icon' => '🎮'
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->where('name', '=', 'Gaming')->delete();
        DB::table('categories')->where('name', '=', 'Reading')->delete();
        DB::table('categories')->where('name', '=', 'Movie')->delete();
        DB::table('categories')->where('name', '=', 'Music')->delete();
        DB::table('categories')->where('name', '=', 'Travel')->delete();
    }
}
