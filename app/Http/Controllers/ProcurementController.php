<?php namespace qilara\Http\Controllers;

use qilara\Http\Requests;
use qilara\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use qilara\Models\Procurement;
use qilara\Models\ProcurementItem;
use Redirect;
use Input;
use Validator;
use Auth;

class ProcurementController extends Controller {

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
            "title" => trans('common.add_procurement')
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

        if(Input::hasFile('offering_letter')) {
            $file = array('image' => Input::file('offering_letter'));
            $rules = array('image' => 'image');
            $validator = Validator::make($file, $rules);

            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            else
            {
                if (Input::file('offering_letter')->isValid()) {
                    $destinationPath = 'uploads';
                    $extension = Input::file('offering_letter')->getClientOriginalExtension();
                    $fileName = basename(Input::file('offering_letter')->getClientOriginalName(), ".".$extension)."_".rand(11111,99999).'.'.$extension;
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
        $procurement->offering_letter   = $fileName;
        $procurement->created_by = Auth::user()->id;


        $procurement->save();

        $cur_proc = Procurement::find($procurement->id);

        if (! empty($_POST['items']))
        {
            $items = json_decode($_POST['items']);

            foreach ($items as $keys => $val)
            {
                $proc_item = new ProcurementItem();
                $proc_item->item_name = $val[0];
                $proc_item->amount = str_replace(",","",$val[1]);
                $proc_item->unit = $val[2];
                $proc_item->unit_price = str_replace(",","",$val[3]);

                $cur_proc->procurement_item()->save($proc_item);
            }
        }

        return Redirect::route('procurement.create')
            ->with('message', trans('common.procurement_saved'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $data = Procurement::find($id);
        $items = ProcurementItem::where('proc_id','=',$id)->get();

        return view('procurement.show', [
            "title" => trans('common.add_procurement'),
            "data" => $data,
            "items" => $items,
        ]);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$procurement = Procurement::find($id);

        $procurement->procurement_item()->delete();

        $procurement->delete();

        return Redirect::back()->with('message', trans('common.offering_deleted'));
    }

}
