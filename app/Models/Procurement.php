<?php namespace qilara\Models;

use Illuminate\Database\Eloquent\Model;

class Procurement extends Model {

    protected $fillable = ['company_name', 'address', 'phone', 'fax', 'contact_person', 'created_by'];

    public function procurement_item()
    {
        return $this->hasMany('qilara\Models\ProcurementItem','proc_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo('qilara\Models\User','created_by', 'id');
    }

    public function invoice()
    {
        return $this->hasOne('qilara\Models\Invoice', 'proc_id', 'id');
    }

}
