<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientModel extends Model
{
    //Povezivanje tabele 'pacijent'
    protected $table = 'pacijent';
    public $timestamps = false;

}
