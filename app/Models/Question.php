<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'team',
        'subject',
        'message',
        'resolved',
        'resolved_by',
        'resolved_at',
        'answer',
        'answered_by',
        'answered_at',
        'discussion_title',
        'discussion_id'
    ];
    
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }
    
    protected $casts = [
        'resolved' => 'boolean',
        'resolved_at' => 'datetime',
        'answered_at' => 'datetime',
    ];
    
    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
    
    public function answerer()
    {
        return $this->belongsTo(User::class, 'answered_by');
    }
}
