<?php namespace qilara\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model {

    protected $fillable = array('proc_id', 'letter_no', 'letter_date','user_id', 'additional_info');

    public function procurement()
    {
        return $this->belongsTo('qilara\Models\Procurement', 'proc_id', 'id');
    }


}
