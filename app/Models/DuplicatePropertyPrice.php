<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuplicatePropertyPrice extends Model
{
    use HasFactory;

    protected $table = 'duplicate_property_pricing';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_id',
        'from',
        'to',
        'per_night_price'
    ];

    /**
     * belongsTo
     */
    public function property()
    {
        return $this->belongsTo(DuplicateProperty::class);
    }

}
