<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sheet_id');
            $table->string('property_id')->nullable();
            $table->string('name')->nullable();
            $table->string('account')->nullable();
            $table->string('pis')->nullable();
            $table->string('pis_sheet_id')->nullable();
            $table->text('google_calendar_link')->nullable();
            $table->string('google_calendar_id')->nullable();
            $table->string('ical_link')->nullable();
            
            $table->string('images_folder_link')->nullable();
            $table->string('youtube_embed_link')->nullable();
            $table->string('property_rating')->nullable();
            $table->string('property_type')->nullable();
            $table->string('design_type')->nullable();
            $table->string('property_manager')->nullable();
            $table->string('max_guests')->nullable();
            $table->string('no_of_beds')->nullable();
            $table->string('no_of_bathrooms')->nullable();
            $table->string('no_of_bedrooms')->nullable();
            $table->text('other_room_details')->nullable();
            $table->text('description')->nullable();
            $table->string('property_size')->nullable();
            $table->string('hotel_complex')->nullable();
            $table->string('gated_community')->nullable();
            $table->string('eco_friendly')->nullable();
            $table->string('view_types')->nullable();
            $table->string('placement_types')->nullable();
            $table->string('curator')->nullable();
            $table->string('parties_events')->nullable();
            $table->string('smoking')->nullable();
            $table->string('pets')->nullable();
            $table->string('adults')->nullable();
            $table->text('good_to_know')->nullable();
            $table->string('coordinates')->nullable();
            $table->string('street')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('location_description')->nullable();
            $table->string('airport')->nullable();

            $table->string('calendar_fallback')->nullable();
            $table->text('comments')->nullable();
            $table->string('slide_link')->nullable();
            $table->string('pdf_link')->nullable();
            $table->string('price_doc_link')->nullable();
            $table->string('price_pdf_link')->nullable();
            $table->text('property_pdf_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
