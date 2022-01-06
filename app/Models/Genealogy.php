<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genealogy extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'representative_id',
        'type',
        'referral_id',
        'reference_id',
        'reference_position',
    ];

    /**
     * Attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = [
        'representative_id',
        'referral_id',
        'reference_id',

        'created_at',
        'updated_at'
    ];

    /**
     * Attributes to cast into native types
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:m-d-Y H:i',
        'updated_at' => 'datetime:m-d-Y H:i',
    ];

    /**
     * Model relationships
     */

    /**
     * Get owning representative
     *
     * @return relation
     */
    public function representative()
    {
        return $this->belongsTo(Representative::class);
    }

    /**
     * Get referral genealogy
     *
     * @return relation
     */
    public function referral() {
        return $this->belongsTo(Genealogy::class, 'referral_id');
    }

    /**
     * Get reference genealogy
     *
     * @return relation
     */
    public function reference() {
        return $this->belongsTo(Genealogy::class, 'reference_id');
    }

    /**
     * Get genealogies that are direct referrals of this genealogy
     *
     * @return relation
     */
    public function referrals() {
        return $this->hasMany(Genealogy::class, 'referral_id');
    }

    /**
     * Get genealogies that reference this genealogy
     *
     * @return relation
     */
    public function referencedBy() {
        return $this->hasMany(Genealogy::class, 'reference_id');
    }
}
