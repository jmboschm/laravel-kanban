<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;


class Appointment extends Model
{
    use HasFactory;
    
    protected $guarded = [ 'id' ];

    protected $fillable = [
        'title',
        'start_time',
        'finish_time',
        'color',
        'user_id'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'user_id';
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

}
