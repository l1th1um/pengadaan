<?php namespace qilara\Http\Controllers;

use qilara\Http\Requests;
use qilara\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use qilara\Models\Invoice;
use qilara\Models\PurchaseOrder;
use Request;
use qilara\Models\Procurement;
use qilara\Models\ProcurementItem;
use Redirect;
use Input;
use Validator;
use Auth;

class ProcurementController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Procurement::orderBy('id', 'desc')->get();
        return view('procurement.index', [
            "title" => trans('common.procurement'),
            "data" => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('procurement.create', [
            "title" => trans('common.add_procurement'),
            'date' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $fileName = "";

        if (Input::hasFile('offering_letter')) {
            $file = array('image' => Input::file('offering_letter'));
            $rules = array('image' => 'image');
            $validator = Validator::make($file, $rules);

            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            } else {
                if (Input::file('offering_letter')->isValid()) {
                    $destinationPath = 'uploads';
                    $extension = Input::file('offering_letter')->getClientOriginalExtension();
                    $fileName = basename(Input::file('offering_letter')->getClientOriginalName(), "." . $extension) . "_" . rand(11111, 99999) . '.' . $extension;
                    Input::file('offering_letter')->move($destinationPath, $fileName);
                }
            }

        }

        $date = explode("/", Request::input('offering_letter_date'));

        $procurement = new Procurement();
        $procurement->company_name = Request::input('company_name');
        $procurement->address = Request::input('address');
        $procurement->phone = Request::input('phone');
        $procurement->fax = Request::input('fax');
        $procurement->contact_person = Request::input('contact_person');

        $procurement->offering_letter_no = Request::input('offering_letter_no');
        $procurement->offering_letter_date = sprintf("%04d-%02d-%02d", $date[2], $date[1], $date[0]);
        $procurement->offering_letter = $fileName;
        $procurement->created_by = Auth::user()->id;


        $procurement->save();

        $cur_proc = Procurement::find($procurement->id);

        if (!empty($_POST['items'])) {
            $items = json_decode($_POST['items']);

            foreach ($items as $keys => $val) {
                $proc_item = new ProcurementItem();
                $proc_item->item_name = $val[1];
                $proc_item->amount = str_replace(",", "", $val[2]);
                $proc_item->unit = $val[3];
                $proc_item->unit_price = str_replace(",", "", $val[4]);

                $cur_proc->procurement_item()->save($proc_item);
            }
        }

        return Redirect::route('dashboard.procurement.index')
            ->with('message', trans('common.procurement_saved'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $data = Procurement::findOrFail($id);

        $order = array('letter_no' => $this->generate_invoice(), 'date' => null, 'info' => null);
        $po = PurchaseOrder::where("proc_id","=",$id)->first();

        if ($po)
        {
            $order['letter_no'] = $po->letter_no;
            $order['date'] = $po->letter_date;
            $order['info'] = $po->additional_info;
        }

        return view('procurement.show', [
            "title" => trans('common.add_procurement'),
            "data" => $data,
            'letter_no' => $order['letter_no'],
            'po_letter_date' => convertToDatepicker($order['date']),
            'additional_info' => $order['info']
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $procurement = Procurement::findOrFail($id);

        $items = $this->jsArray($procurement->procurement_item);

        return view('procurement.create', [
            "title" => trans('common.add_procurement'),
            "procurement" => $procurement,
            "items" => $items,
            'date' => convertToDatepicker($procurement->offering_letter_date)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $date = explode("/", Request::input('offering_letter_date'));

        $procurement = Procurement::find($id);
        $procurement->company_name = Request::input('company_name');
        $procurement->address = Request::input('address');
        $procurement->phone = Request::input('phone');
        $procurement->fax = Request::input('fax');
        $procurement->contact_person = Request::input('contact_person');

        $procurement->offering_letter_no = Request::input('offering_letter_no');
        $procurement->offering_letter_date = sprintf("%04d-%02d-%02d", $date[2], $date[1], $date[0]);

        if (Input::hasFile('offering_letter')) {
            $file = array('image' => Input::file('offering_letter'));
            $rules = array('image' => 'image');
            $validator = Validator::make($file, $rules);

            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            } else {
                if (Input::file('offering_letter')->isValid()) {
                    $destinationPath = 'uploads';
                    $extension = Input::file('offering_letter')->getClientOriginalExtension();
                    $fileName = basename(Input::file('offering_letter')->getClientOriginalName(), "." . $extension) . "_" . rand(11111, 99999) . '.' . $extension;
                    Input::file('offering_letter')->move($destinationPath, $fileName);

                    $procurement->offering_letter = $fileName;
                }
            }

        }

        $procurement->updated_by = Auth::user()->id;

        $procurement->save();

        $cur_proc = Procurement::find($id);

        ProcurementItem::where("proc_id", "=", $id)->delete();

        if (!empty($_POST['items'])) {
            $items = json_decode($_POST['items']);

            foreach ($items as $keys => $val) {
                $proc_item = new ProcurementItem();
                $proc_item->item_name = $val[1];
                $proc_item->amount = str_replace(",", "", $val[2]);
                $proc_item->unit = $val[3];
                $proc_item->unit_price = str_replace(",", "", $val[4]);

                $cur_proc->procurement_item()->save($proc_item);
            }
        }

        return Redirect::route('dashboard.procurement.index')
            ->with('message', trans('common.procurement_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $procurement = Procurement::find($id);

        $procurement->procurement_item()->delete();

        $procurement->delete();

        return Redirect::back()->with('message', trans('common.offering_deleted'));
    }

    public function postInvoice($id)
    {
        //echo $id;
        $file = array('image' => Input::file('invoice'));
        $rules = array('image' => 'image');
        $validator = Validator::make($file, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $procurement = Procurement::find($id);
            $procurement->proc_status = Request::input('status');
            $procurement->save();

            if (Request::hasFile('invoice') && Request::file('invoice')->isValid()) {
                $destinationPath = 'uploads';
                $extension = Request::file('invoice')->getClientOriginalExtension();
                $fileName = basename(Request::file('invoice')->getClientOriginalName(), "." . $extension) . "_" . rand(11111, 99999) . '.' . $extension;
                Request::file('invoice')->move($destinationPath, $fileName);

                $invoice = Invoice::firstOrNew(['proc_id' => $id]);
                $invoice->path = $fileName;
                $invoice->user_id = Auth::user()->id;

                $procurement->invoice()->save($invoice);
            }

            return Redirect::back()
                ->with('message', trans('common.status_saved'));
        }
    }

    public function jsArray($data)
    {
        $str = '[';
        foreach ($data as $val) {
            $str .= '["' . $val->id . '","' . $val->item_name . '", "' . number_format($val->amount) . '", "' . $val->unit . '","' . number_format($val->unit_price) . '"],';
        }

        $str = substr($str, 0, -1) . "];";

        return $str;
    }

    public function purchaseOrder($id)
    {
        $data = Procurement::with('purchase_order')->findOrFail($id);

        return view('procurement.purchase_order', [
            "data" => $data
        ]);
    }

    public function generate_invoice()
    {
        $month = date('n');
        $month = numberToRoman($month);

        $year = date('Y');

        $suffix = "/PP-BTPK/PO/" . $month . "/" . $year;
        $po = PurchaseOrder::where("letter_no", "LIKE", "%" . $suffix)->orderBy('letter_no', 'desc')->first();

        if (!$po) {
            return "001" . $suffix;
        } else {
            $number = intval(substr($po->letter_no, 0, 3));
            return sprintf("%03d",($number + 1)) . $suffix;
        }
    }

    public function printPO($id)
    {
        $po = PurchaseOrder::where("proc_id","=",$id)->first();
        $date = explode("/", Request::input('po_letter_date'));

        $po->proc_id = $id;
        $po->letter_no = Request::input('purchase_order_no');
        $po->letter_date = sprintf("%04d-%02d-%02d", $date[2], $date[1], $date[0]);

        $po->user_id = Auth::user()->id;
        $po->additional_info = Request::input('additional_info');
        $po->save();

        $url = route('dashboard.procurement.purchase_order', $id);
        link_new_window($url);

        return Redirect::route('dashboard.procurement.show', $id)
            ->with('message', trans('common.purchase_order_saved'));
    }

}
