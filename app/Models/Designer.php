<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPHtmlParser\Dom;
use Storage;

class Designer extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    static private $baseUrl = 'https://arkhitex.ru';
    protected $table = 'designers';

    public static function getData() {
        $html = file_get_contents('https://arkhitex.ru/designer/');
        $dom = new Dom;
        $dom->loadStr($html);
        $designersData = [];
        $designers = $dom->find('.indproject-list-item');
        // $designers = array_slice($designers->toArray(), 0, 2);

        foreach ($designers as $key => $designer) {
            $url = self::$baseUrl . $designer->find('.indproject-list-item-img', 0)->getAttribute('href');
            $designerHtml = file_get_contents($url);
            $designerDom = new Dom;
            $designerDom->loadStr($designerHtml);
            $itemData = [];
            $itemData['name'] = $designerDom->find('.designer-detail .container h1', 0)->innerText;
            $itemData['speciality'] = $designerDom->find('.designer-detail .container .font-14', 0)->innerText;
            $itemData['city'] = $designerDom->find('.designer-detail .container .gray', 0)->innerText;
            $itemData['description'] = $designerDom->find('.designer-detail .container .font-14', 2)->innerText;
            $itemData['hash'] = md5($itemData['name'] . $itemData['city']);

            if (self::where(['hash' => $itemData['hash']])->exists()) {
                continue;
            }

            $style = $designer->find('.indproject-list-item-img', 0)->getAttribute('style');
            preg_match('/url\((.*)\)/', $style, $matches);
            $name = substr($matches[1], strrpos($matches[1], '/') + 1);
            $nameArray = [];
            $nameArray[] = $name;
            $itemData['images'] = json_encode($nameArray);
            $contents = file_get_contents(self::$baseUrl . $matches[1]);
            Storage::disk('public')->put('/designers/' . $name, $contents);
            $designersData[] = $itemData;
            self::insert([$itemData]);
        }
        // self::insert($designersData);
    }
    
    public function getImagesAttribute($value) {
        if (is_null($value)) {
            $value = [];
        }

        return $value;
    }
}
