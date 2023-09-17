<?php

namespace Modules\Tutorial\Http\Controllers;

use Brryfrmnn\Transformers\Json;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Tutorial\Entities\Tutorial;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data = Tutorial::entities($request->entities)
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
    public function create()
    {
        return view('tutorial::create');
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

            $master = new Tutorial();
            $master->title = $res['title'];
            $master->url_youtube = $url_embed;
            $master->url_thumbnail = $res['thumbnail_url'];
            $master->slug = \Str::slug($res['title']);
            $master->status = $request->status;
            $master->author_id = $request->user()->id;
            $master->save();

            return Json::response($master);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('tutorial::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('tutorial::edit');
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
