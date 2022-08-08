<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['amount', 'status', 'ticket_id'];

    protected $searchableFields = ['*'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
