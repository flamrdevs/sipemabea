<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'email',
        'person_in_charge',
        'members',
        'phone_number',
        'agency',
        'goal',
        'start_date',
        'end_date',
        'proposal_link',
        'cover_letter_link',
        'attachment_link',
        'note',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
