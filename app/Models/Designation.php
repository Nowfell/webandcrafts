<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    /**
    * Get the employee that owns the Designation
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'designation_id');
    }
}
