<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designer;
use App\Models\Project;

class DesignerController extends Controller
{
    public function designers() {
        $designers = Designer::all();
        foreach ($designers as $designer) {
            $designer['images'] = json_decode($designer['images']);
        }
        return view('designers', [
            'designers' => $designers->toArray(),
        ]);
    }

    public function choosen($id) {
        $designer = Designer::where(['id' => $id])->get()[0];
        $designer['images'] = json_decode($designer['images']);
        $name = $designer['name'];
        $projects = Project::where(['author' => $name])->get()->toArray();
        foreach ($projects as $key=>$project) {
            $projects[$key]['images'] = json_decode($project['images']);
        }
        return view('choosen', [
            'designer' => $designer,
            'projects' => $projects,
        ]);
    }

    public function create() {
        $action = route('designer-create');
        return view('create', [
            'action' => $action,
        ]);
        
    }


    public function edit($id) {
        $action = route('designer-edit');
        $designer = Designer::where(['id' => $id])->first();
        if ($designer) {
            $designer['images'] = json_decode($designer['images']);
            // dd($designer);
        return view('create', [
            'action' => $action,
            'designer' => $designer->toArray(),
        ]);
        } else {
            $action = route('designer-create');
            return view('create', [
                'action' => $action,
            ]);
        } 
        
    }

    public function submit(Request $request) {
        $validated = $request->validate([
            'designer' => ['required'],
            'special' => ['required'],
            'city' => ['required'],
            'description' => ['required'],
        ]);
        // $req = $request->toArray();
        
        $files = $request->toArray()['files'];
        $fileNames = [];
        foreach ($files as $file) {
            $path = $file->store('designers', 'public');
            $name = substr($path, strrpos($path, '/')+1);
            $fileNames[] = $name;
            
        }
        
        Designer::insert([
            'name' => $request['designer'],
            'speciality' => $request['special'],
            'city' => $request['city'],
            'description' => $request['description'],
            'images' => $fileNames,
        ]);
    
        
        $designers = Designer::all();
        foreach ($designers as $designer) {
            $designer['images'] = $designer['images'];
        }
        // dd($designer);
        return view('designers', [
            'designers' => $designers->toArray(),
        ]);
    }

    public function update(Request $request) {
        $validated = $request->validate([
            'designer' => ['required'],
            'special' => ['required'],
            'city' => ['required'],
            'description' => ['required'],
        ]);
        $scratch = explode(',', $request->files_to_delete);
        // dd($scratch);

        $data = $request->toArray();
        
        $fileNames = [];
        
        if (isset($data['files'])) {
            $files = $data['files'];

            foreach ($files as $file) {
                $path = $file->store('designers', 'public');
                $name = substr($path, strrpos($path, '/')+1);
                $fileNames[] = $name;
            }
            
        }

        $designer = Designer::where(['id' => $data['id']])->first();

        if (!$designer) {
            return response()->json([
                'status' => false
            ]);
        }

        $images = $designer['images'];
        // dd($designer['images']);
        foreach ($images as $key=>$image) {
            $isMatch = in_array($image, $scratch);
            if ($isMatch) {
                unset($images[$key]);
            }
            
        }
        $images = array_merge($images, $fileNames);
        // dd($images);
        $isUpdate = $designer->update([
            'name' => $request['designer'],
            'speciality' => $request['special'],
            'city' => $request['city'],
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
        $designer = Designer::where(['id' => $id])->first();
        if ($designer) {
            $name = $designer->name;
            // $projects = Project::where(['author' => $name])->get();
            // $projects->delete();
            // $designer->delete();
        } 
        return view('choosen');
    }
}
