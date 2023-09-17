<?php

namespace Modules\Room\Http\Controllers;

use App\Http\Helpers\MethodsHelpers;
use Brryfrmnn\Transformers\Json;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Room\Entities\Video;
use Modules\Studio\Entities\Studio;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function summary(Request $request)
    {
        try {
            $studio = MethodsHelpers::gettersStudio($request);
            $data = [
                "all" => 0,
                "publish" => 0,
                "draft" => 0,
                "new" => 0,
            ];

            $data["all"] = Video::where('studio_id', $studio->id)
                ->count();
            $data["publish"] = Video::where('studio_id', $studio->id)
                ->where('status', 'publish')
                ->count();
            $data["draft"] = Video::where('studio_id', $studio->id)
                ->where('status', 'draft')
                ->count();
            $data['new'] = Video::where('studio_id', $studio->id)
                ->whereDate('created_at', '=', Carbon::today()->toDateString())
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
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $studio = MethodsHelpers::gettersStudio($request);
            $video = Video::where('studio_id', $studio->id)
                ->entities($request->entities)
                ->get();
            return Json::response($video);
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
        return view('room::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $studio = MethodsHelpers::gettersStudio($request);
            $data_videos = MethodsHelpers::setDataVideoYt($request->urls);
            $data_previews = MethodsHelpers::setDataVideoYt($request->preview_urls);

            $video = new Video();
            $video->name = $request->name;
            $video->description = $request->description;
            $video->about = $request->about;
            $video->status = $request->status;
            $video->studio_id = $studio->id;
            $video->data_videos = json_encode($data_videos);
            $video->data_previews = json_encode($data_previews);
            $video->save();
            return Json::response($video);
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
            $studio = MethodsHelpers::gettersStudio($request);
            $data = Video::where('studio_id', $studio->id)->where('id', $id)->first();
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
