<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'user_id',
        'name',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function inventoryDetails()
    {
        return $this->hasMany(InventoryDetailsModel::class, 'inventory_id', 'id');
    }
}
