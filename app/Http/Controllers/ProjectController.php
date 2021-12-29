<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Designer;

class ProjectController extends Controller
{
    public function project($id) {
        $project = Project::where(['id' => $id])->with(['author'])->first()->toArray();
        $plans = [];

        if (!empty($project['plans'])) {
            $plans = json_decode($project['plans'], true);
            foreach ($plans as $key=>$plan) {
                $plans[$key]['title'] = json_decode($plan['title']);
            }
        }
       
        $newProject = [];
        $newProject['name'] = ['Дизайнер', $project['author']['name']];
        $columns = [
            'name' => 'Дизайнер',
            'style' => 'Стиль',
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
        $designers = Designer::all();
        return view('addProject', [
            'action' => $action,
            'designers' => $designers,
        ]);
    }

    public function edit($id) {
        $action = route('project-edit');
        $project = Project::where(['id' => $id])->first();
        $designers = Designer::all();

        if ($project) {
            $project['images'] = json_decode($project['images']);
            return view('addProject', [
                'action' => $action,
                'project' => $project,
                'designers' => $designers,
                'id' => $id,
            ]);
        } else {
            return view('addProject', [
                'action' => $action,
                'designers' => $designers,
            ]);
        }
    }

    public function submit(Request $request) {
        $validated = $request->validate([
            'selected' => ['required'],
            'title' => ['required'],
            
        ]);
        $req = $request->toArray();
        $fileNames = [];
        
        if (isset($req['images'])) {
            $files = $req['images'];

            foreach ($files as $file) {
                $path = $file->store('projects', 'public');
                $name = substr($path, strrpos($path, '/')+1);
                $fileNames[] = $name;   
            }
        }
        $data = [
            
            'designer_id' => $req['selected'],
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

        return response()->json([
            'status' => true
        ]);
    }

    public function update(Request $request) {
        $validated = $request->validate([
            'selected' => ['required'],
            'title' => ['required'],
        ]);
        
        $scratch = explode(',', $request->files_to_delete);
        $data = $request->toArray();
        $fileNames = [];
        
        if (isset($data['images'])) {
            $files = $data['images'];

            foreach ($files as $file) {
                $path = $file->store('projects', 'public');
                $name = substr($path, strrpos($path, '/')+1);
                $fileNames[] = $name;
            }  
        }

        $project = Project::where(['id' => $data['id']])->first();

        if (!$project) {
            return response()->json([
                'status' => false
            ]);
        }

        $images = json_decode($project['images']);

        foreach ($images as $key=>$image) {
            $isMatch = in_array($image, $scratch);
            if ($isMatch) {
                unset($images[$key]);
            }
            
        }
        $images = array_merge($images, $fileNames);
        $designer = Designer::where(['id' => $data['selected']])->first();
        $isUpdate = $project->update([
            
            'designer_id' => $data['selected'],
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
    
    public function delete($id) {
        Project::where(['id' => $id])->delete();
        return redirect('/designers');
    }
}
