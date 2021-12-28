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

    public function create() {
        $action = route('project-create');
        return view('addProject', [
            'action' => $action,
        ]);
    }

    public function edit($id) {
        $action = route('project-edit');
        $project = Project::where(['id' => $id])->first();
        
        if ($project) {
            $project['images'] = json_decode($project['images']);
            // dd(gettype($project['images']));
            return view('addProject', [
                'action' => $action,
                'project' => $project,
            ]);
        } else {
            return view('addProject', [
                'action' => $action,
            ]);
        }
    }

    public function submit(Request $request) {
        $validated = $request->validate([
            'author' => ['required'],
            'title' => ['required'],
            
        ]);
        
       
        
        $req = $request->toArray();
        $fileNames = [];

        if ($req['images']) {
            $files = $req['images'];
            foreach ($files as $file) {
                $path = $file->store('projects', 'public');
                $name = substr($path, strrpos($path, '/')+1);
                $fileNames[] = $name;   
            }
        }
        // dd($req);
        $data = [
            'author' => $req['author'],
            'title' => $req['title'],
            'style' => $req['style'],
            'price' => $req['price'],
            'fullPrice' => $req['fullPrice'],
            'footage' => $req['footage'],
            'productionTime' => $req['productionTime'],
            'chooseOption' => $req['chooseOption'],
            'section' => $req['section'],
            'description' => $req['description'],
            'images' => json_encode($fileNames)
        ];
        
        Project::insert($data);
        
        return 'okey';
    }

    public function update(Request $request) {
        $validated = $request->validate([
            'author' => ['required'],
            'title' => ['required'],
        ]);

        $scratch = explode(',', $request->files_to_delete);

        $data = $request->toArray();
        // dd($data);
        $fileNames = [];
        
        if (isset($data['images'])) {
            $files = $data['images'];

            foreach ($files as $file) {
                $path = $file->store('projects', 'public');
                $name = substr($path, strrpos($path, '/')+1);
                $fileNames[] = $name;
            }
            
        }

        $project = Project::where(['author' => $data['author']])->first();

        if (!$project) {
            return response()->json([
                'status' => false
            ]);
        }

        $images = json_decode($project['images']);
        // dd($designer['images']);
        // dd($images);
        foreach ($images as $key=>$image) {
            $isMatch = in_array($image, $scratch);
            if ($isMatch) {
                unset($images[$key]);
            }
            
        }
        $images = array_merge($images, $fileNames);
        // dd($images);
        $isUpdate = $project->update([
            'author' => $request['author'],
            'title' => $request['title'],
            'style' => $request['style'],
            'price' => $request['price'],
            'fullPrice' => $request['fullPrice'],
            'footage' => $request['footage'],
            'productionTime' => $request['productionTime'],
            'chooseOption' => $request['chooseOption'],
            'section' => $request['section'],
            'description' => $request['description'],
            'images' => $images,
        ]);

        if ($isUpdate) {
            return response()->json([
                'status' => true,
            ]);
        }
    }
    
}
