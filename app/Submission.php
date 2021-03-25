<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'email',
        'person_in_charge',
        'phone_number',
        'agency',
        'goal',
        'start_date',
        'proposal_link',
        'cover_letter_link',
        'attachment_link',
        'note',
        'status',
    ];
}
