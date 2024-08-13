<?php

namespace Uzinfocom\Dastyor\Models;


use Illuminate\Database\Eloquent\Model;

class ColumnType extends Model {

    protected $fillable = [
        'name', 'hasLength', 'defaults'
    ];
}