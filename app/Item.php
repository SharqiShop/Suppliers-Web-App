<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function mainorder()
    {
    	return $this->belongsTo(Mainorder::Class);
    }
}
