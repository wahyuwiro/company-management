<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'logo', 'website'];

    /**
     * Get the employees associated with the company.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function getLogoUrlAttribute()
    {
        // return $this->logo ? Storage::url($this->logo) : null;
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
}
