<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->route()->getName();

        return view('main', ['section' => $section]);
    }

    public function nodes(Request $request)
    {
        if ($request->ajax()) {
            return (new NodeController)->index($request);
        } else {
            return view('main', ['section' => 'nodes']);
        }
    }

    public function lines(Request $request)
    {
        if ($request->ajax()) {
            return (new LineController)->index($request);
        } else {
            return view('main', ['section' => 'lines']);
        }
    }

    public function admin(Request $request)
    {
        if ($request->ajax()) {
            return (new AdminController)->index($request);
        } else {
            return view('main', ['section' => 'admin']);
        }
    }

    public function adminNodeTypes(Request $request, $id = '')
    {
        if ($request->ajax()) {
            if(isset($id) && !empty($id)) {
                return (new NodeTypeController)->getById($id);
            } else {
                return (new NodeTypeController)->index($request);
            }
        } else {
            if(isset($id) && !empty($id)) {
                return view('main', ['section' => '/admin/nodetypes/'.$id]);
            } else {
                return view('main', ['section' => '/admin/nodetypes']);
            }
        }
    }

    public function adminLineTypes(Request $request, $id = '')
    {
        if ($request->ajax()) {
            if(isset($id) && !empty($id)) {
                return (new LineTypeController)->getById($id);
            } else {
                return (new LineTypeController)->index($request);
            }
        } else {
            if(isset($id) && !empty($id)) {
                return view('main', ['section' => '/admin/linetypes/'.$id]);
            } else {
                return view('main', ['section' => '/admin/linetypes']);
            }
        }
    }
}
