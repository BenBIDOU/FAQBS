<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'telephone',
        'ville_bs',
        'address',
        'postal_code',
        'city',
        'country',
        'function',
        'skills',
        'bio',
        'email_notifications',
        'sms_notifications',
        'photo',
        'signature',
        'birth_date',
        'membership_start',
        'membership_end',
        'is_active',
        'is_verified',
        'notes',
    ];

    protected $casts = [
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'birth_date' => 'date',
        'membership_start' => 'date',
        'membership_end' => 'date',
    ];

    // Relation avec User (One-to-One)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
