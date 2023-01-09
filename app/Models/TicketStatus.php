<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    use HasFactory;

    const OPEN = 1;

    const IN_PROGRESS = 2;

    const MERGED = 3;

    const DEPLOYED = 4;

    const REVIEW = 5;

    const DONE = 6;

    const CLOSED = 7;

    protected $fillable = [
        'status',
        'color',
    ];

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'ticket_status', 'id');
    }
}
