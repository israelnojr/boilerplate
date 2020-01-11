<?php

namespace boxe;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class shippment extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created( function($shippment){
            $shippment->info()->create([
                'trackId' => $shippment->key,
            ]);

        });
    }
    public function info()
    {
        return $this->hasMany(info::class);
    }

    public function user()
    {
        return $this->blongsTo(User::class, 'user_id');
    }
}
