<?php

namespace Modules\Room\Http\Controllers;

use Brryfrmnn\Transformers\Json;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Room\Entities\InstructorHasClass;
use Modules\Room\Entities\Live;
use Modules\Room\Entities\UrlPreview;
use Modules\Studio\Entities\Studio;

class LiveController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $data = Live::entities($request->entities)
                ->whereWithEntities('studio', $user_id, 'owner_id')
                ->summary($request->summary)
                ->order($request->order)
                ->dataLimit($request->limit)
                ->search($request->q, $request->role)
                ->get();

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
     * Display a listing of the resource.
     * @return Renderable
     */
    public function indexAll(Request $request)
    {
        try {
            $data = Live::entities($request->entities)
                ->summary($request->summary)
                ->order($request->order)
                ->dataLimit($request->limit)
                ->search($request->q, $request->role)
                ->get();

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
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function summary(Request $request)
    {
        try {
            $data = [
                "all" => 0,
                "status" => [
                    'all' => 0,
                    "publish" => 0,
                    "draft" => 0,
                    "suspend" => 0,
                    "deleted" => 0,
                ],
                'activation' => [
                    'all' => 0,
                    "active" => 0,
                    "non_active" => 0.
                ],
                "new" => 0,
            ];

            $user_id = $request->user()->id;
            $studio =  Studio::where('owner_id', $user_id)->first();

            $data['all'] = Live::where('studio_id', $studio->id)->count();
            $data['status']['all'] = Live::where('status', '!=', null)->withTrashed()->where('studio_id', $studio->id)->count();
            $data['status']['publish'] = Live::where('status', 'publish')->where('studio_id', $studio->id)->count();
            $data['status']['draft'] = Live::where('status', 'draft')->where('studio_id', $studio->id)->count();
            $data['status']['suspend'] = Live::where('status', 'suspend')->where('studio_id', $studio->id)->count();
            $data['status']['deleted'] = Live::where('studio_id', $studio->id)->onlyTrashed()->count();
            $data["activation"]['all'] = Live::where('is_active', '!=', null)->where('studio_id', $studio->id)->count();
            $data["activation"]['active'] = Live::where('is_active', true)->where('studio_id', $studio->id)->count();
            $data["activation"]['non_active'] = Live::where('is_active', false)->where('studio_id', $studio->id)->count();
            $data['new'] = Live::whereDate('created_at', '=', Carbon::today()->toDateString())->where('studio_id', $studio->id)->count();

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
            $user_id = $request->user()->id;
            $studio =  Studio::where('owner_id', $user_id)->first();
            if ($studio) {
                $data = new Live();
                $data->name = $request->name;
                $data->slug = Live::generatedSlug($request->name);
                $data->description = $request->description;
                $data->about = $request->about;
                $data->studio_id = $studio->id;
                $data->media_id = $request->media_id;
                $data->status = $request->status;
                $data->is_active = $request->is_active;
                $data->category_id = $request->category_id;
                $data->save();

                if (is_array($request->instructor_id)) {
                    foreach ($request->instructor_id as $key => $id) {
                        $instructor = new InstructorHasClass();
                        $instructor->live_class_id = $data->id;
                        $instructor->instructor_id = $id;
                        $instructor->save();
                    }
                }

                $data->instructor;
                return Json::response($data);
            } else {
                return Json::exception("your account is not owner");
            }
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
     * @return Renderable
     */

    public function addPreviewClass(Request $request, $class_id)
    {
        // try {
        // dd($request->url);
        $ytId = explode('v=', $request->url);
        if (isset($ytId[1])) {
            $content_id = $ytId[1];
            $split = explode('&', $ytId[1]);
            $content_id = $split[0];
        } else {
            $content_id = $url;
        }
        $id_yt = $content_id;
        $full_Url = 'https://www.youtube.com/watch?v=' . $content_id;
        $url_embed = 'https://www.youtube.com/embed/' . $content_id;
        $client = new Client();
        $response = $client->get('https://www.youtube.com/oembed?url=' . $full_Url);
        $res = json_decode($response->getBody(), true);
        // dd();

        $master = new UrlPreview();
        $master->data_video = json_encode($res);
        $master->url = $url_embed;
        $master->module = "live_class";
        $master->live_class_id = $class_id;
        $master->save();
        $master->live_class;

        return Json::response($master);
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request, $id)
    {
        try {
            $data = Live::entities($request->entities)->findOrFail($id);

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
    public function showLiveClass(Request $request, $id)
    {
        try {
            $user_id = $request->user()->id;
            $studio = Studio::where('owner_id', $user_id)->first();
            $data = Live::entities($request->entities)
                ->where('studio_id', $studio->id)
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
        return view('room::edit');
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
            $data = Live::findOrFail($id);
            $data->name = $request->input("name", $data->name);
            $data->description = $request->input('description', $data->description);
            $data->about = $request->input('about', $data->about);
            $data->studio_id = $request->input("studio_id", $data->studio_id);
            $data->media_id = $request->input("media_id", $data->media_id);
            $data->status = $request->input("status", $data->status);
            $data->is_active = $request->input('is_active', $data->is_active);
            $data->category_id = $request->input("category_id", $request->category_id);
            $data->save();
            $data->category;

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
    public function destroy($id, Request $request)
    {
        try {

            $user_id = $request->user()->id;
            $studio =  Studio::where('owner_id', $user_id)->first();
            $data = Live::whereWithEntities('studio', $user_id, 'owner_id')
                ->where('id', $id)->first();
            $data->delete();
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
     * Remove the specified resources from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroys($id)
    {
        try {
            if (!is_array($id)) {
                Json::exception("data tidak valid");
            }

            $data = Live::whereIn($id)->get();
            $data->delete();
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
     * Remove the specified resources from storage.
     * @param int $id
     * @return Renderable
     */
    public function restore($id)
    {
        try {

            $data = Live::onlyTrashed()->findOrFail($id);
            $data->deleted_at = null;
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
}
