<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComboServicio extends Model
{
    protected $table = 'combo_servicio';
    protected $primaryKey = 'idComboServicio';
    public $timestamps = true;

    protected $fillable = [
        'idCombo',
        'idServicio'
    ];
}