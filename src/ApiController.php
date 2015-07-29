<?php namespace Crtek\Authenticator;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Crtek\Authenticator\Models\User as User;
use Illuminate\Contracts\Auth\Guard;
use Auth;
//crtek
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory as JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiController extends Controller {

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
	public function update(Request $request)
	{
		//update user info
		$user = Auth::User();
       	$user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
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

	//crtek :)
	public function getUser(){
		$user = Auth::User();
        return $user;
	}
}
