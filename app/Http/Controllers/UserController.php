<?php namespace qilara\Http\Controllers;

use qilara\Http\Controllers\Controller;

use qilara\Models\Role;
use qilara\Models\RoleUser;
use qilara\Models\User;
use Request;
use Hash;
use Redirect;
use Validator;
use Auth;


class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $data = User::with('userRole.roles')->orderBy('id', 'desc')->get();

        return view('users.index', [
            "title" => trans('common.users'),
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
        return view('users.create', [
            "title" => trans('common.add_user'),
            'role' => $this->listRole(),
            'selected_role' => null
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
            'name' => 'required|min:4',
            'username' => 'required|min:4',
            'email' => 'email',
            'password' => 'required|alphaNum||min:5|confirmed'
        );
        $validator = Validator::make(Request::all(),$rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        else
        {
            $user = new User();
            $user->name = Request::input('name');
            $user->username = Request::input('username');
            $user->email = Request::input('email');
            $user->password = Hash::make(Request::input('password'));
            $user->save();

            $user_role = User::find($user->id);
            $role = new RoleUser();
            $role->role_id = Request::input('role');

            $user_role->userRole()->save($role);

            return Redirect::route('dashboard.users.index')
                ->with('message', trans('common.user_created'));
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
        $user = User::findOrFail($id);

        return view('users.create', [
            "title" => trans('common.users'),
            'user' => $user,
            'role' => $this->listRole(),
            'selected_role' => $user->userRole->role_id
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
        $rules = array(
            'name' => 'required|min:4',
            'username' => 'required|min:4',
            'email' => 'email',
            'password' => 'confirmed'
        );
        $validator = Validator::make(Request::all(),$rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        else
        {
            $user = User::findorFail($id);
            $user->name = Request::input('name');
            $user->username = Request::input('username');
            $user->email = Request::input('email');

            if (Request::has('password'))
                $user->password = Hash::make(Request::input('password'));

            $user->save();

            //$user_role = User::findorFail($id);
            $role = RoleUser::where('user_id','=',$id)->first();
            $role->role_id = Request::input('role');
            $role->save();

            return Redirect::route('dashboard.users.index')
                ->with('message', trans('common.user_updated'));
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
        $user = User::find($id);
        $user->delete();

        return Redirect::back()->with('message', trans('common.users_deleted'));
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

    public function listRole()
    {
        $data = array();
        foreach (Role::all() as $val)
        {
            $data[$val->id] = $val->display_name;
        }

        return $data;
    }
}
