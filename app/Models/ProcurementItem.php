<?php namespace qilara\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementItem extends Model {

    protected $fillable = ['proc_id', 'item_name', 'amount', 'unit', 'unit_price'];
    protected $table = 'proc_items';

    public function procurement()
    {
        return $this->belongsTo('qilara\Models\Procurement','proc_id', 'id');
    }

}
