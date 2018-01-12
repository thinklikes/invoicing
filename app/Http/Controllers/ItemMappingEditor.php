<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Http\Requests;
use Exception;
use App\Platform;

class ItemMappingEditor extends Controller
{
    private $itemMappingFileName = 'ItemMapping.txt';

    public function index()
    {
        $platforms = Platform::where('isDisabled', 0)->get();

        return view('erp.sale.itemMappingEditor.index', [
            'platforms' => $platforms,
        ]);
    }
    
    public function subIndex($platform)
    {
        $text = [];

        try {
            $content = json_decode(Storage::get($this->itemMappingFileName));
            // 結合json

            foreach ($content->{$platform} as $key => $string) {
                $text[$key] = implode(' => ', $string);
            }
            $content = implode("\r\n", $text);

        } catch (Exception $e) {
            $content = '';
        }


        return view('erp.sale.itemMappingEditor.subIndex', [
            'content' => $content,
            'platform' => $platform,
        ]);
    }

    public function save(Request $request) {
        $content = $request->input('content');
        $platform = $request->input('platform');

        try {
            $originContent = json_decode(Storage::get($this->itemMappingFileName));
            // 結合json

        } catch (Exception $e) {
            $originContent = new \stdClass();

            $originContent->{$platform} = array();
        }

        $content = explode("\r\n", $content);

        foreach ($content as $key => $string) {
            $string = array_map(function ($item) {
                return trim($item);
            }, explode("=>", $string));

            $content[$key] = $string;
        }

        $originContent->{$platform} = $content;

        Storage::put($this->itemMappingFileName, json_encode($originContent));

        $status = ['修改成功'];

        return redirect()->route('itemMappingEditor::index')->with(['status' => $status]);
    }
}
