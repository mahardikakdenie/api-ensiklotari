<?php

namespace Modules\User\Http\Controllers;

use Brryfrmnn\Transformers\Json;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Studio\Entities\Studio;
use Modules\User\Entities\User;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $studio =  Studio::where('owner_id', $user_id)->first();

            $team = User::whereWithEntities('studio', $studio->id, 'id')
                ->orwhere('studio_id', $studio->id)
                ->entities($request->entities)
                ->get();

            return Json::response($team);
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
    public function summary(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $studio =  Studio::where('owner_id', $user_id)->first();

            $data = [
                'all' => [
                    "all" => 0,
                    'admin' => 0,
                    'instructor' => 0,
                    'owner' => 0,
                ],
                'active' => 0,
                'non_active' => 0,
                'new' => 0,
            ];
            // All Data Summary
            $data['all']['all'] = User::whereWithEntities('studio', $studio->id, 'id')
                ->orWhere('studio_id', $studio->id)
                ->count();

            // ALL Data Summary Admin
            $data['all']['admin'] = User::whereWithEntities('baseCamp', $studio->id, 'id')
                ->whereWithEntities('role', 'admin', 'name')
                ->count();

            // All Data Summary Instructor
            $data['all']['instructor'] = User::whereWithEntities('baseCamp', $studio->id, 'id')
                ->whereWithEntities('role', 'instructor', 'name')
                ->count();

            // All Data Summary Owner Studio
            $data['all']['owner'] = User::whereWithEntities('studio', $studio->id, 'id')
                ->whereWithEntities('role', 'owner', 'name')
                ->count();

            // all user active
            $data['active'] = User::whereWithEntities('studio', $studio->id, 'id')
                ->orWhere('studio_id', $studio->id)
                ->where('is_active', 1)
                ->count();
            // all user non active
            $data['non_active'] = User::whereWithEntities('studio', $studio->id, 'id')
                ->orWhere('studio_id', $studio->id)
                ->where('is_active', 0)
                ->count();

            // all user new
            $data['new'] = User::whereWithEntities('baseCamp', $studio->id, 'id')->whereDate('created_at', '=', Carbon::today()->toDateString())
                ->count();

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
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $user_id = $request->user()->id;
            $studio =  Studio::where('owner_id', $user_id)->first();

            $data = new User();
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->about = $request->about;
            $data->address = $request->address;
            $data->is_active = false;
            $data->role_id = $request->role_id;
            $data->certificate_id = $request->certificate_id;
            $data->media_id = $request->media_id;
            $data->studio_id = $studio->id;
            $data->save();

            $data->role;
            $data->media;

            DB::commit();
            return Json::response($data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return Json::exception('Error Model ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return Json::exception('Error Query ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\ErrorException $e) {
            DB::rollBack();
            return Json::exception('Error Exception ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::show');
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
        //
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
