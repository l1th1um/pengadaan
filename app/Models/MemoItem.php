<?php namespace qilara\Models;

use Illuminate\Database\Eloquent\Model;

class MemoItem extends Model {

    public function memo()
    {
        return $this->belongsTo('qilara\Models\Memo','memo_id', 'id');
    }

}
