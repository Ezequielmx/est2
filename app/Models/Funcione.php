<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcione extends Model
{
    use HasFactory;
    
    public function evento(){
        return $this->belongsTo('App\Models\Evento');
    }

    public function tema(){
        return $this->belongsTo('App\Models\Tema');
    }

    public function reservas(){
        return $this->belongsToMany('App\Models\Reserva');
    }
}
