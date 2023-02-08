<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuplicateProperty extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clickup_id',
        'sheet_id',
        'property_id',
        'currency',
        'currency_symbol',
        'community',
        'name',
        'account',
        'pis',
        'pis_sheet_id',
        'google_calendar_link',
        'google_calendar_id',
        'ical_link',
        'images_folder_link',
        'youtube_embed_link',
        'property_rating',
        'property_type',
        'design_type',
        'property_manager',
        'max_guests',
        'no_of_beds',
        'no_of_bathrooms',
        'no_of_bedrooms',
        'other_room_details',
        'description',
        'property_size',
        'hotel_complex',
        'gated_community',
        'eco_friendly',
        'view_types',
        'placement_types',
        'curator',
        'parties_events',
        'smoking',
        'pets',
        'adults',
        'good_to_know',
        'coordinates',
        'street',
        'zip_code',
        'destination',
        'city',
        'country',
        'location_description',
        'airport',
        'calendar_fallback',
        'comments',
        'slide_link',
        'pdf_link',
        'price_doc_link',
        'price_pdf_link',
        'property_pdf_notes'
    ];

    /**
     * belongsTo
     */
    public function sheet()
    {
        return $this->belongsTo(Sheet::class);
    }

    /**
     * hasMany
     */
    public function events()
    {
        return $this->hasMany(DuplicateEvent::class);
    }

}
