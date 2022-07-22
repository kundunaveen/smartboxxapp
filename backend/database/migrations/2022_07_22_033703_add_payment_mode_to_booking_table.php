<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentModeToBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->enum('mode',['offline','online'])->default('offline')->after('user_id');
            $table->string('description')->nullable()->after('mode');
            $table->string('trasaction_id')->nullable()->after('status');
            $table->string('amount')->nullable()->after('trasaction_id');
            $table->text('payment_method')->nullable()->after('trasaction_id');
            $table->enum('payment_status',['success','failed','pending'])->default('pending')->after('payment_method');

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
            $table->dropColumn(['mode','description','trasaction_id','payment_method','payment_status']);
        });
    }
}
