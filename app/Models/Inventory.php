<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Added this line for HasFactory trait

class Inventory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    //
}
