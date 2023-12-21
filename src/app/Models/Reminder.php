<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'remind_at',
        'event_at',
        'description',
        'user_id',
    ];

    protected $appends = ['remind_at_label','event_at_label'];

    public function getRemindAtLabelAttribute(){
        return Carbon::createFromTimestamp($this->attributes['remind_at'])->translatedFormat('F Y');
        
    }
    public function getEventAtLabelAttribute(){
        return Carbon::createFromTimestamp($this->attributes['event_at'])->translatedFormat('F Y');
        
    }

    

    public function user(){
        return $this->belongsTo(User::class);
    }
}
