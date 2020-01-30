<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatmentModel extends Model
{
    //Povezivanje tabele 'lecenje'
    protected $table = 'lecenje';
    public $timestamps = false;
}
