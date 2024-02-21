<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $primaryKey = 'type_id';

    protected $fillable = [
        'name',
        'description',
        'cost',
    ];

    public function products()
    {    return $this->belongsTo(Product::class, 'type_id', 'type_id');   }
}
