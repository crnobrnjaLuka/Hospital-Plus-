<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiseaseModel extends Model
{
    //Povezivanje tabele 'bolest'
    protected $table = 'bolest';
    public $timestamps = false;
}
