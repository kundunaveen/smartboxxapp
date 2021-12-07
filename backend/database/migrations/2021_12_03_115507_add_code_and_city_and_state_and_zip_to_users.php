<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeAndCityAndStateAndZipToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
           
            $table->string('state')->after('code');
            $table->string('city')->after('state');
            $table->integer('zip')->after('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
        
              $table->dropColumn('state');
              $table->dropColumn('city');
              $table->dropColumn('zip');
        });
    }
}
