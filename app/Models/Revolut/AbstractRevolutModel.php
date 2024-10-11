<?php

namespace App\Models\Revolut;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class AbstractRevolutModel extends Model
{
//    use HasFactory, SoftDeletes;
//    use Searchable;

//    protected static function booted()
//    {
//        static::addGlobalScope('active', function (Builder $builder) {
//            $builder->where('status', 'active');
//        });
//    }

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $term = "%$term%";
            $query->where(function($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('description', 'like', $term);
            });
        }
    }
}
