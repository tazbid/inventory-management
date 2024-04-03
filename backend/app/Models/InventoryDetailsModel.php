<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDetailsModel extends Model
{
    use HasFactory;

    protected $table = 'inventory_details';

    protected $fillable = [
        'inventory_id',
        'name',
        'description',
        'quantity'
    ];

    public function inventory()
    {
        return $this->belongsTo(InventoryModel::class, 'inventory_id', 'id');
    }
}
