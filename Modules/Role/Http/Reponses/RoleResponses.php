<?php

namespace Modules\Role\Http\Responses;

class RoleResponses
{
    public static function response($data = null, $message = null, $status = true, $code = 200, $additional = null, $group = null)
    {
        if ($message == null) {
            $message = __('message.success');
        }
        if ($data == null) {
            $data = [];
        }
        $result['meta']['status'] = $status;
        $result['meta']['message'] = $message;
        $result['meta']['code'] = $code;
        if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {

            $pagination = $data->toArray();
            $result['meta']['total'] = $data->total();
            $result['meta']['per_page'] = $data->perPage();
            $result['meta']['current_page'] = $data->currentpage();
            $result['meta']['last_page'] = $data->lastPage();
            $result['meta']['from'] = $pagination['from'];;
            $result['meta']['to'] = $pagination['to'];
            $result['links']['next'] = $data->nextPageUrl();
            $result['links']['prev'] = $data->previousPageUrl();
            $result['links']['first'] = $pagination['first_page_url'];
            $result['links']['last'] = $pagination['last_page_url'];

            if ($group != null) {

                $data = $data->groupBy($group);
                foreach ($data as $key => $value) {
                    $group_item[] = [
                        'group' => $key,
                        'item' => $value
                    ];
                }
                $result['data'] = $group_item;
            } else {
                dd($data->all());
                $result['data'] = $data->all();
            }


            // $result = collect($result);
            // $result = $result->merge($data);
        } else {
            $result['data'] = $data;
        }

        if ($additional != null) {
            foreach ($additional as $add) {
                $result['meta'][$add['name']] = $add['data'];
            }
        }
        // $result['code'] = 200;
        $code = 200;
        return response()->json($result, $code);
    }


    public static function exception($message = null, $error = null, $status = false, $code = 400)
    {
        if ($message == null) {
            $message = __('message.error');
        }
        $result['data'] = [];
        $result['meta']['status'] = $status;
        $result['meta']['message'] = $message;
        $result['meta']['code'] = $code;
        if ($error instanceof \ErrorException) {
            $result['error']['message'] = $error->getMessage();
            $result['error']['file'] = $error->getFile();
            $result['error']['line'] = $error->getLine();
        } else {
            $result['error'] = $error;
        }
        return response()->json($result, 200);
    }
}
