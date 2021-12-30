<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPHtmlParser\Dom;
use Storage;
use App\Models\Designer;

class Project extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    static private $baseUrl = 'https://arkhitex.ru';
    protected $table = 'projects';

    public function getData() {
        $html = file_get_contents(self::$baseUrl . '/designer');
        $dom = new Dom;
        $dom->loadStr($html);
        $projectData = [];
        $designers = $dom->find('.indproject-list-item')->toArray();
        // $designers = array_slice($designers, 0, 2);
        
        foreach ($designers as $designer) {
            $url = self::$baseUrl . $designer->find('.indproject-list-item-img', 0)->getAttribute('href');
            $designerHtml = file_get_contents($url);
            $designerDom = new Dom;
            $designerDom->loadStr($designerHtml);
            $projects = $designerDom->find('.indproject-list-item.magazin-list-item');

            foreach($projects as $project) {
                $path = $project->find('.indproject-list-item-img', 0)->getAttribute('href');
                $hash = md5($path);

                if (self::where(['hash' => $hash])->exists()) {
                    continue;
                }

                $projectUrl = self::$baseUrl . $path;
                $projectHtml = file_get_contents($projectUrl);
                $projectDom = new Dom;
                $projectDom->loadStr($projectHtml);
                
                $projectParams = $projectDom->find('.pt-5 .container .col-auto.mb-4');
                $itemData = [];

                foreach($projectParams as $param) {
                    $existParam = $param->find('.font-15.gray.mb-2',0);
                    $columns = [
                        'style' => 'Стиль',
                        'author' => 'Дизайнер',
                        'price' => 'Цена за м2',
                        'fullPrice' => 'Стоимость',
                        'productionTime' => 'Сроки производства',
                        'footage' => 'Метраж',
                        'chooseOption' => 'Выбор опции',
                        'section' => 'Раздел',
                        'drawing' => 'Чертеж проекта'
                    ];
                    
                    if (!empty($existParam)) {
                        $pat = $existParam->innerText;
                        
                        foreach($columns as $key=>$column) {
                            $isMatch = stripos($pat, $column);
                            $itemData[$key] = $itemData[$key] ?? null;
                            $itemData['title'] = $projectDom->find('.arkhitex-detail-title.m-0', 0)->innerText;

                            if ($isMatch !== false) {
                                echo $param->find('.font-16', 0);

                                if ($key == 'author') {
                                    $designer = Designer::where(['name' => $param->find('.font-16', 0)->innerText])->first();
                                    $itemData['designer_id'] = $designer->id;
                                }

                                if ($key == 'drawing') {
                                    $name = substr($param->find('.font-16 a', 0)->getAttribute('href'), strrpos($param->find('.font-16 a', 0)->getAttribute('href'), '/') + 1);
                                    $contents = file_get_contents('https://arkhitex.ru' . $param->find('.font-16 a', 0)->getAttribute('href'));
                                    Storage::disk('public')->put('/plans/' . $name, $contents);
                                    $itemData[$key] = json_encode([$name]);
                                } else {
                                    $itemData[$key] = $param->find('.font-16', 0)->innerText;
                                }
                            }
                        }
                    }    
                }
                $projectAbout = $projectDom->find('.col-12.col-md-8.mb-4', 0);
                $findType = gettype($projectAbout->find('.font-18.line-height15.mb-4', 0));
                
                if ($findType == 'object') {
                    $itemData['description'] = $projectAbout->find('.font-18.line-height15.mb-4', 0)->innerText;
                } else {
                    $itemData['description'] = null;
                }
                echo $projectAbout->find('.font-18.line-height15.mb-4');
                $whatIncluded = $projectAbout->find('.what-is-included.mb-4', 0);
                $slideImg = $projectDom->find('.planirovki-detail-slider-area .planirovki-detail-slider .mr-4');
                $images = [];

                foreach ($slideImg as $img) {
                    $name = substr($img->getAttribute('href'), strrpos($img->getAttribute('href'), '/') + 1);
                    $contents = file_get_contents('https://arkhitex.ru' . $img->getAttribute('href'));
                    Storage::disk('public')->put('/projects/' . $name, $contents);
                    echo $name;
                    $images[] = $name;
                }
                $itemData['hash'] = $hash;
                $itemData['images'] = json_encode($images);
                

                $planList = [];
                $planList[] = $projectDom->find('.col-12.col-md-8.mb-4 .what-is-included.mb-4 #what-is-included-1 a')->getAttribute('href');
                $planList[] = $projectDom->find('.col-12.col-md-8.mb-4 .what-is-included.mb-4 #what-is-included-4 a')->getAttribute('href');
                $planList[] = $projectDom->find('.col-12.col-md-8.mb-4 .what-is-included.mb-4 #what-is-included-5 a')->getAttribute('href');
                $planList[] = $projectDom->find('.col-12.col-md-8.mb-4 .what-is-included.mb-4 #what-is-included-6 a')->getAttribute('href');
                $planList[] = $projectDom->find('.col-12.col-md-8.mb-4 .what-is-included.mb-4 #what-is-included-7 a')->getAttribute('href');
                $planList[] = $projectDom->find('.col-12.col-md-8.mb-4 .what-is-included.mb-4 #what-is-included-8 a')->getAttribute('href');
                $planList[] = $projectDom->find('.col-12.col-md-8.mb-4 .what-is-included.mb-4 #what-is-included-9 a')->getAttribute('href');
                $planList[] = $projectDom->find('.col-12.col-md-8.mb-4 .what-is-included.mb-4 #what-is-included-10 a')->getAttribute('href');
                $planList[] = $projectDom->find('.col-12.col-md-8.mb-4 .what-is-included.mb-4 #what-is-included-11 a')->getAttribute('href');
                $planList[] = $projectDom->find('.col-12.col-md-8.mb-4 .what-is-included.mb-4 #what-is-included-11 a', 1)->getAttribute('href');
                $plans = [];
                $titles = $projectDom->find('.col-12.col-md-8.mb-4 .what-is-included.mb-4 .collapsed.d-block.mb-2');
                $planTitles = [];

                foreach ($titles as $key=>$title) {
                    
                    if ($key != 0) {
                        $planTitles[] = $title->innerText;
                    }
                }

                foreach($planList as $key=>$plan) {
                    $name = substr($plan, strrpos($plan, '/') + 1);
                    $contents = file_get_contents('https://arkhitex.ru' . $plan);
                    Storage::disk('public')->put('/plans/' . $name, $contents);
                    echo '$planTitles[$key] ' . $planTitles[$key];
                    $plans[] = [
                        'title' => json_encode($planTitles[$key], JSON_UNESCAPED_UNICODE),
                        'image' => $name
                    ];
                }
                $itemData['plans'] = json_encode($plans, JSON_UNESCAPED_UNICODE);
                // $projectData[] = $itemData;
                unset($itemData['author']);   
                self::insert($projectData);
            }   
        }
        // self::insert($projectData);
    }

    public function getImagesAttribute($value) {
        if (is_null($value)) {
            $value = json_encode([]);
        }

        return $value;
    }

    public function getPlansAttribute($value) {
        if (is_null($value)) {
            $value = json_encode([]);
        }

        return $value;
    }

    public function getDrawingAttribute($value) {
        if (is_null($value)) {
            $value = json_encode([]);
        }

        return $value;
    }

    public function author() {
        return $this->belongsTo(Designer::class, 'designer_id', 'id');
    }
}
