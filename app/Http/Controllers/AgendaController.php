<?php namespace qilara\Http\Controllers;

use qilara\Http\Requests;
use qilara\Http\Controllers\Controller;

use qilara\Models\Agenda;
use Validator;
use Request;
use Redirect;
use Input;

class AgendaController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = Agenda::orderBy('id', 'desc')->get();

		return view('agenda.index', [
				"title" => trans('common.agenda'),
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
		return view('agenda.create', [
				"title" => trans('common.add_agenda')
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
				'title' => 'required|min:4'
		);
		$validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		} else {
            $date = explode("/", Request::input('agenda_date'));

			$agenda = new Agenda();
			$agenda->title = Request::input('title');
			$agenda->agenda_date = sprintf("%04d-%02d-%02d", $date[2], $date[1], $date[0]);
			$agenda->save();

			return Redirect::route('dashboard.agenda.index')
					->with('message', trans('common.agenda_created'));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		$data = Agenda::findOrFail($id);

		return view('agenda.create', [
				"title" => trans('common.agenda'),
				'data' => $data
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
		$data = Agenda::findOrFail($id);

		return view('agenda.create', [
				"title" => trans('common.agenda'),
				'data' => $data
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
		$rules = ['title' => 'required|min:4'];

		$validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		} else {
            $date = explode("/", Request::input('agenda_date'));

            $agenda = Agenda::findorFail($id);
            $agenda->title = Request::input('title');
            $agenda->agenda_date = sprintf("%04d-%02d-%02d", $date[2], $date[1], $date[0]);
			$agenda->save();

			return Redirect::route('dashboard.agenda.index')
					->with('message', trans('common.agenda_updated'));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$agenda = Agenda::find($id);
		$agenda->delete();

		return Redirect::back()->with('message', trans('common.agenda_deleted'));
	}

    public function showAgenda()
    {
        $year = Input::get('year');
        $month = Input::get('month');

        $agenda = Agenda::whereRaw("year(agenda_date) = ".$year." AND month(agenda_date) = ".$month)->get();

        $data = array();

        if ($agenda)
        {
            $i = 0;
            foreach ($agenda as $val)
            {
                $data[$i]['date'] = $val->agenda_date;
                $data[$i]['badge'] = true;
                $data[$i]['title'] = localeDate($val->agenda_date);
                $data[$i]['body'] = $val->title;
            }
        }

        return json_encode($data);
    }
}