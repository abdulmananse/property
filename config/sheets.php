<?php

return [
    'post_spreadsheet_id' => env('POST_SPREADSHEET_ID'),
    'sheets_to_be_imported' => [
        '🏡 Information',
        '💰 Pricing'
    ],
    'keys_information' => [
        ['index' => 4, 'value_index' => 5, 'db_key' => 'images_folder_link'],
        ['index' => 5, 'db_key' => 'youtube_embed_link'],
        ['index' => 7, 'db_key' => 'google_calendar_link'],
        ['index' => 8, 'db_key' => 'ical_link'],
        ['index' => 13, 'db_key' => 'currency'],
        ['index' => 29, 'db_key' => 'property_rating'],
        ['index' => 30, 'db_key' => 'property_type'],
        ['index' => 31, 'db_key' => 'design_type'],
        ['index' => 32, 'db_key' => 'owner_name'],
        ['index' => 33, 'db_key' => 'property_manager'],
        ['index' => 34, 'db_key' => 'max_guests'],
        ['index' => 35, 'db_key' => 'no_of_beds'],
        ['index' => 36, 'db_key' => 'no_of_bathrooms'],
        ['index' => 37, 'db_key' => 'no_of_bedrooms'],
        ['index' => 38, 'db_key' => 'description'],
        ['index' => 39, 'db_key' => 'tag_line'],
        ['index' => 40, 'db_key' => 'property_size'],
        ['index' => 41, 'db_key' => 'hotel_complex'],
        ['index' => 42, 'db_key' => 'gated_community'],
        ['index' => 43, 'db_key' => 'eco_friendly'],
        ['index' => 44, 'db_key' => 'view_types'],
        ['index' => 45, 'db_key' => 'placement_types'],
        ['index' => 46, 'db_key' => 'curator'],
        ['index' => 48, 'db_key' => 'parties_events'],
        ['index' => 49, 'db_key' => 'smoking'],
        ['index' => 50, 'db_key' => 'pets'],
        ['index' => 51, 'db_key' => 'adults'],
        ['index' => 52, 'db_key' => 'good_to_know'],
        ['index' => 53, 'db_key' => 'coordinates'],
        ['index' => 54, 'db_key' => 'street'],
        ['index' => 55, 'db_key' => 'zip_code'],
        ['index' => 56, 'db_key' => 'city'],
        ['index' => 57, 'db_key' => 'country'],
        ['index' => 58, 'db_key' => 'location_description'],
        ['index' => 59, 'db_key' => 'airport'],
        ['index' => 68, 'db_key' => 'other_room_details'],
        ['index' => 72, 'db_key' => 'destination'],
        ['index' => 73, 'db_key' => 'community']
    ],
    'keys_pricing' => [
        ['index' => 1, 'db_key' => 'from'],
        ['index' => 2, 'db_key' => 'to'],
        ['index' => 10, 'db_key' => 'per_night_price']
    ]
];
