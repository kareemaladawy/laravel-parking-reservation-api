<?php


namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;

trait UserRecord
{
    public static function bootUserRecord()
    {
        static::addGlobalScope('user', function (Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }
}
