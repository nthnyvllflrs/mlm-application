<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenealogyWallet extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'genealogy_id',
        'balance',
        'accumulated_balance',
    ];

    /**
     * Attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = [
        'genealogy_id',

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
     * Get owning genealogy
     *
     * @return relation
     */
    public function genealogy()
    {
        return $this->belongsTo(Genealogy::class);
    }
}
