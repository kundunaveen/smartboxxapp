<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeAndCityAndStateAndZipToBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->string('code')->after('address');
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
        Schema::table('booking', function (Blueprint $table) {
              $table->dropColumn('code');
              $table->dropColumn('state');
              $table->dropColumn('city');
              $table->dropColumn('zip');
        });
    }
}
