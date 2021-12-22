<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function project($id) {
        $project = Project::where(['id' => $id])->first()->toArray();
        $plans = json_decode($project['plans'], true);
        foreach ($plans as $key=>$plan) {
            $plans[$key]['title'] = json_decode($plan['title']);
        }
        $newProject = [];
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
        foreach($project as $key=>$param) {
            if ($key == 'drawing') {
                $param = json_decode($param);   
            }
            if ($key == 'images') {
                $project[$key] = json_decode($param);
            }
            foreach($columns as $sKey=>$value) {
                
                if (($key == $sKey) && ($param != null)) {
                    $newProject[$key] = [$value, $param];
                }
            } 
        }
        return view('project', [
            'project' => $project,
            'newProject' => $newProject,
            'plans' => $plans,
        ]);
    }
}
