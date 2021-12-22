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
}
