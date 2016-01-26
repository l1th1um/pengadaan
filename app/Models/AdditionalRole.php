<?php namespace qilara\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalRole extends Model {

    public function users()
    {
        return $this->belongsTo('qilara\Models\User', 'add_role', 'id' );
    }

}
