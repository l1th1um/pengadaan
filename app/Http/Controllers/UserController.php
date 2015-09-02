<?php namespace qilara\Http\Controllers;

use qilara\Http\Controllers\Controller;

use Request;
use Hash;
use Redirect;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
		//
	}

    public  function  changePassword()
    {
        return view('users.change_password', [
            "title" => trans('common.change_password')
        ]);
    }

    public  function  postChangePassword()
    {
        $user = \Auth::user();
        $rules = array(
            'old_password' => 'required|between:4,16',
            'password' => 'required|between:4,16|confirmed'
        );

        $validator = \Validator::make(Request::all(), $rules);

        if ($validator->fails())
        {
            return redirect('dashboard/change_password')->withErrors($validator);
        }
        else
        {
            if (!Hash::check(Request::input('old_password'), $user->password))
            {
                return redirect('dashboard/change_password')->withErrors('Your old password does not match');
            }
            else
            {
                $user->password = Hash::make(Request::input('password'));
                $user->save();
                return Redirect::action('UserController@changePassword',$user->id)->withMessage("Password have been changed");
            }
        }
    }

    public function profile()
    {
        return view('users.profile', [
            "title" => trans('common.profile')
        ]);
    }
}
