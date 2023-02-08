<?php

namespace App\Models;

use App\Models\Property as Property;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyPrice extends Model
{
    use HasFactory;

    protected $table = 'property_pricing';

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
        return $this->belongsTo(Property::class);
    }

}
