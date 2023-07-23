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
        'booked_by',
        'user_id'
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

}
