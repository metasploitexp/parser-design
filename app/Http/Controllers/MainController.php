<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designer;
use App\Models\Project;


class MainController extends Controller
{
    public function parser() {
        Designer::getData();
        $parser = Designer::all();
        return view('parser', [
            'parser' => $parser->toArray(),
        ]);
        
    }
    public function parserProjects() {
        Project::getData();
        $projects = Project::all();
        return view('parserProjects', [
            'parserProjects' => $projects->toArray(),
        ]);
    }
}
