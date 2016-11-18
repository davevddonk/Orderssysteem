<?php

namespace App;

class Order extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'status', 'pick_up_adres_id', 'deliver_adres_id', 'sender_id', 'client_id', 'deliver_time_til', 'pick_up_time_from', 'orderref' , 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];
}