<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Script;

class ScriptController extends Controller
{
    public function index() {
        $script = Script::all();
        
        $id = count($script) > 0 ? $script[0]->id : '';
        $scriptjs = count($script) > 0 ? htmlspecialchars($script[0]->script) : '';

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
