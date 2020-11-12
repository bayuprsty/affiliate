<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Script;

class ScriptController extends Controller
{
    public function index() {
        $script = Script::all();
        
        $id = isset($script) ? $script[0]->id : '';
        $scriptjs = isset($script) ? htmlspecialchars($script[0]->script) : '';

        return view('admin.script.index', compact('id', 'scriptjs'));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            if (empty($request->id_script)) {
                $created = Script::create(['script' => $request->script]);
            } else {
                $script = Script::findOrfail($request->id_script);

                $updated = $script->update(['script' => $request->script]);
            }

            return $this->sendResponse('Script Updated');
        }
    }
}
