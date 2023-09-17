<?php

namespace App\Http\Helpers;

use Illuminate\Support\Str;
use Modules\Studio\Entities\Studio;
use GuzzleHttp\Client;

class MethodsHelpers
{
    public static function order($query, $order)
    {
        if ($order === '-id') {
            $query->orderBy('id', "desc");
        }

        return $query;
    }

    public static function entities($query, $entities)
    {
        if ($entities != null || $entities != '') {
            $entities = str_replace(' ', '', $entities);
            $entities = explode(',', $entities);

            try {
                return $query = $query->with($entities);
            } catch (\Throwable $th) {
                return Json::exception(null, validator()->errors());
            }
        }
    }

    public static function limit($query, $limit)
    {
        if ($limit) {
            $query->limit($limit);
        }

        return $query;
    }

    public static function search($query, $q, $records = 'name')
    {
        if ($q) {
            $query->where($records, $q);
        }

        return $query;
    }

    public static function trashData($query, $is_trash)
    {
        if ($is_trash) {
            $query->onlyTrashed();
        }

        return $query;
    }

    public static function scopeGeneratedSlug($q, $title)
    {
        $new_slug = Str::slug($title);
        $slug_check = $q->where('slug', $new_slug)->count();
        if ($slug_check == 0) {
            $slug = $new_slug;
        } else {
            $check = 0;
            $unique = false;
            while ($unique == false) {
                $inc_id = ++$check;
                $check = $q->where('slug', $new_slug . '-' . $inc_id)->count();
                if ($check > 0) {
                    $unique = false;
                } else {
                    $unique = true;
                }
            }
            $slug = $new_slug . '-' . $inc_id;
        }

        return $slug;
    }

    public static function whereWithEntities($query, $entities, $field, $target)
    {
        if ($entities && $field) {
            $query->whereHas($entities, function ($queryBuilder) use ($field, $target) {
                $queryBuilder->where($target, $field);
            });
        }

        return $query;
    }

    public static function whereWithSummary($query, $target, $summary)
    {
        if ($summary && $target) {
            $query->where($target, $summary);
        }
    }

    public static function getterUserId($request)
    {
        return $request ? $request->user()->id : null;
    }

    public static function gettersStudio($request)
    {
        $studio = Studio::where('owner_id', MethodsHelpers::getterUserId($request))->first();
        return $studio;
    }

    public static function setEmbedYoutube($url)
    {
        $ytId = explode('v=', $url);
        if (isset($ytId[1])) {
            $content_id = $ytId[1];
            $split = explode('&', $ytId[1]);
            $content_id = $split[0];
        } else {
            $content_id = $url;
        }
        $id_yt = $content_id;
        $full_Url =  'https://www.youtube.com/watch?v=' . $content_id;
        $url_embed = 'https://www.youtube.com/embed/' . $content_id;
        $client = new Client();
        $response = $client->get('https://www.youtube.com/oembed?url=' . $full_Url);
        $res = json_decode($response->getBody(), true);
        $data = [...$res, 'url_embed' => $url_embed];
        return $data;
    }

    public static function setDataVideoYt($urls)
    {
        $data = [];
        if (is_array($urls)) {
            foreach ($urls as $key => $url) {
                $res = MethodsHelpers::setEmbedYoutube($url);
                array_push($data, $res);
            }
        }

        return $data;
    }


    // DRY -> dont repeat yourself // 
}
