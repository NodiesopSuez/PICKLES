<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Favorites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> string('type', 10);
            $table -> string('title');
            $table -> string('artist');
            $table -> string('artwork', 2100);
            $table -> string('end_url', 2100);
            $table -> string('release', 10);
            $table -> string('album_title') -> nullable();
            $table -> string('user_id') -> nullable();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
