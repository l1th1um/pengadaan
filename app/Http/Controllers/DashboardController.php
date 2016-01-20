<?php namespace qilara\Http\Controllers;

use qilara\Http\Requests;
use Illuminate\Http\Request;
use qilara\Models\Announcement;
use qilara\Models\User;
use Hash;
use Entrust;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//use Illuminate\Database\Query\Builder;

class DashboardController extends Controller {
	
	use AuthenticatesAndRegistersUsers;
	
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		//$this->middleware('guest', ['except' => 'getLogout']);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $announcement = Announcement::limit(4)->orderBy('id', 'desc')->get();

		return view('dashboard', [
            "title" => trans('common.home'),
			"announcement" => $announcement
        ]);
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

	public function login()
	{
        return view('login.login');
	}

   public function postLogin(Request $request)
	{
		$this->validate($request, [
			'username' => 'required', 'password' => 'required',
		]);

		$field = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    	$request->merge([$field => $request->input('username')]);

		$credentials = $request->only($field, 'password');

		if (\Auth::attempt($credentials, $request->has('remember')))
		{
			return redirect()->intended('dashboard');
		}

		return redirect('dashboard/login')
					->withInput($request->only('username', 'remember'))
					->withErrors([
						'username' => $this->getFailedLoginMessage(),
					]);
	}

    public function logout()
    {
    	\Auth::logout();
    	return redirect('dashboard');
    }

    public function redirectPath()
	{
		/*if (property_exists($this, 'redirectPath'))
		{
			return $this->redirectPath;
		}*/

		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/dashboard';
	}


}
