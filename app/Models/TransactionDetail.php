<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $table = 'transaction_detail';
    protected $guarded = ['id'];
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function item()
    {
        return $this->belongsTo(Items::class, 'items_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(Items::class, "id", "items_id");
    }
}
