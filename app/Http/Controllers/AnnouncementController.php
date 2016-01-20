<?php namespace qilara\Http\Controllers;

use qilara\Http\Requests;
use qilara\Http\Controllers\Controller;

use qilara\Models\Announcement;
use Validator;
use Request;
use Redirect;

class AnnouncementController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = Announcement::orderBy('id', 'desc')->get();

		return view('announcement.index', [
				"title" => trans('common.announcement'),
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
		return view('announcement.create', [
				"title" => trans('common.add_announcement')
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
		$validator = Validator::make(Request::all(),$rules);

		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}
		else
		{
			$announcement = new Announcement();
			$announcement->title = Request::input('title');
			$announcement->content = Request::input('content');
			$announcement->save();

			return Redirect::route('dashboard.announcement.index')
					->with('message', trans('common.announcement_created'));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$data = Announcement::findOrFail($id);

		return view('announcement.create', [
				"title" => trans('common.announcement'),
				'data' => $data
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
		$data = Announcement::findOrFail($id);

		return view('announcement.create', [
				"title" => trans('common.announcement'),
				'data' => $data
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = [ 'title' => 'required|min:4' ];

		$validator = Validator::make(Request::all(),$rules);

		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}
		else
		{
			$announcement = Announcement::findorFail($id);
			$announcement->title = Request::input('title');
			$announcement->content = Request::input('content');
			$announcement->save();

			return Redirect::route('dashboard.announcement.index')
					->with('message', trans('common.announcement_updated'));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$announcement = Announcement::find($id);
		$announcement->delete();

		return Redirect::back()->with('message', trans('common.announcement_deleted'));
	}

	public function showAnnouncement($id)
	{
		$announcement = Announcement::find($id);

		return json_encode($announcement);
	}
}
