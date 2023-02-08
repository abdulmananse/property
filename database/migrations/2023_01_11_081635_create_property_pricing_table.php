<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyPricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->index('property_id');
            $table->index('name');
            $table->index('destination');
            $table->string('currency')->after('sheet_id')->nullable();
            $table->string('currency_symbol')->after('currency')->nullable();
            $table->string('community')->after('currency_symbol')->nullable();
        });
        Schema::create('property_pricing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->index();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->double('per_night_price')->nullable();
            $table->timestamps();
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->index('community');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('currency');
            $table->dropColumn('currency_symbol');
            $table->dropColumn('community');
            $table->dropIndex('property_id');
            $table->dropIndex('name');
            $table->dropIndex('destination');
        });
        Schema::dropIfExists('property_pricing');
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex('community');
        });
    }
}
