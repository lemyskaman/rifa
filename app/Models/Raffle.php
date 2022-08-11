<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Raffle extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'date'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
    ];

    public function terminals()
    {
        return $this->hasMany(Terminal::class);
    }
}
