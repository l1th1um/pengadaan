<?php namespace qilara\Models;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model {

    public function memo_item()
    {
        return $this->hasMany('qilara\Models\MemoItem','memo_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo('qilara\Models\User', 'user_id', 'id' );
    }
}
