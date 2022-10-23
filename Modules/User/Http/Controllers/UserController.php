<?php

namespace Modules\User\Http\Controllers;

use Brryfrmnn\Transformers\Json;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $user = User::entities($request->entities)
                ->order($request->order)
                ->dataLimit($request->limit)
                ->get();
            return Json::response($user);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Json::exception('Error Model ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\Illuminate\Database\QueryException $e) {
            return Json::exception('Error Query ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\ErrorException $e) {
            return Json::exception('Error Exception ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        }

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $data = new User();
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->about = $request->about;
            $data->address = $request->address;
            $data->role_id = $request->role_id;
            $data->save();
            return Json::response($data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Json::exception('Error Model ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\Illuminate\Database\QueryException $e) {
            return Json::exception('Error Query ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\ErrorException $e) {
            return Json::exception('Error Exception ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id, Request $request)
    {
        try {
            $data = User::entities($request->entities)
             ->findOrFail($id);

             return Json::response($data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Json::exception('Error Model ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\Illuminate\Database\QueryException $e) {
            return Json::exception('Error Query ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\ErrorException $e) {
            return Json::exception('Error Exception ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        try {
            $data = User::findOrFail($id);
            $data->name = $request->input('name', $data->name);
            $data->email = $request->input('email', $data->email);
            $data->password = Hash::make($request->password);
            $data->username = $request->input("username", $data->username);
            $data->about = $request->input('about', $data->about);
            $data->address = $request->input('address', $data->address);
            $data->role_id = $request->input('role_id', $data->role_id);
            $data->save();
            return Json::response($data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Json::exception('Error Model ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\Illuminate\Database\QueryException $e) {
            return Json::exception('Error Query ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\ErrorException $e) {
            return Json::exception('Error Exception ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
