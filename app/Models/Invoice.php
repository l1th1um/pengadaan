<?php namespace qilara\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

    public function users()
    {
        return $this->belongsTo('qilara\Models\User', 'user_id', 'id' );
    }

    public function procurement()
    {
        return $this->belongsTo('qilara\Models\Procurement', 'proc_id', 'id');
    }

}
