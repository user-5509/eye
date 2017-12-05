<?php

namespace App\Http\Controllers;

use App\EyeConfig;
use App\NodeType;
use App\Node;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return view('content.admin.index');
    }

    public function types(Request $request)
    {
        $types = (new NodeType)->all();
        return view('content.admin.types', ['types' => $types]);
    }

    public function checkRootNode()
    {
        $config = new EyeConfig();

        $rootNodeType = $config->get('rootNodeType');
        if(!isset($rootNodeType)) {
            $config->set('rootNodeType', 1);
        }

        $rootNode = (new Node)->where('type_id', '=', $rootNodeType)->get();
        if($rootNode->count() === 0) {
            $rootNode = new Node();
            $rootNode->name = 'Мир';
            $rootNode->type_id = $rootNodeType;
            $rootNode->save();

            $config->set('globalRootNode', $rootNode->id);
        }
    }
}
