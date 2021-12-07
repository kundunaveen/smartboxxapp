<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionLatLongToDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device', function (Blueprint $table) {
            $table->string('description');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device', function (Blueprint $table) {
            // if (Schema::hasColumn('device', 'description'))
            // {
            // $table->dropColumn('description');
            // }
            // if (Schema::hasColumn('device', 'lat'))
            // {
            // $table->dropColumn('lat');
            // }
            // if (Schema::hasColumn('device', 'long'))
            // {
            // $table->dropColumn('long');
            // }
        });
    }
}
