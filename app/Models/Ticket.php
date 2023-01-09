<?php

namespace App\Models;

use App\Http\Traits\EntryAutomation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes, EntryAutomation;

    protected $fillable = [
        'project_id',
        'staff_id',
        'ticket_code',
        'ticket_title',
        'ticket_status',
        'ticket_priority',
        'description',
        'created_by',
    ];

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function ticketStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'ticket_status', 'id');
    }
}
