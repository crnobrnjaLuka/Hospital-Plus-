<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CureModel extends Model
{
    //Povezivanje tabele 'lek'
    protected $table = 'lek';
    public $timestamps = false;
}
