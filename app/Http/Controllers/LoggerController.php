<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoggerController extends Controller
{
    public function writeData(Request $request) {
        
        $content = "@table piarc \n@mode edit \n@istru tag, time, value, mode \n";

        $params = json_decode($request->getContent());
        $timestamp = date('d-M-Y H:i:s');
        $tags = [];
        $valuewritten = 0;

        foreach($params as $p) {
            $tag_timestamp = $timestamp;
            if($p->timestamp_date) {
                $date = date('d-M-Y', strtotime($p->timestamp_date));
                $time = date('H:i:s', strtotime($p->timestamp_date));
                $tag_timestamp = $date . ' ' . $time;
            }

            if($p->value) {
                
                $tags[] = [
                    'tag_name' => $p->tag,
                    'timestamp' => $tag_timestamp,
                    'value' => $p->value
                ];

                $content .= $p->tag . ", " . $tag_timestamp . ", '" . $p->value . "', replace \n";
                $valuewritten += 1;
            }
        }
        
        if($valuewritten > 0) {
            $filename = date('Ymdhis') . '.inp';
            file_put_contents(env('PICONFIG_PATH') . '\\' . $filename, $content);

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Submitted ' . $valuewritten . ' Value(s)',
                'data' => ['timestamp' => $timestamp, 'values' => $tags]
            ]);
        }
        
        return response()->json([
            'status' => 'failed',
            'message' => 'No Data has been written',
        ]);
    }
}
