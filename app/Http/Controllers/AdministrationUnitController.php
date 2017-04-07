<?php

namespace App\Http\Controllers;

use App\Models\AdministrationUnit;
use Illuminate\Http\Request;

class AdministrationUnitController extends Controller
{
    public function getChildren(Request $request)
    {
        $childrenType = $request->input('type');
        $curId = $request->input('current_id');
        $curUnit = AdministrationUnit::find($curId);
        $childrenObj = $curUnit->children;
        $children = [];
        if (sizeof($childrenObj) === 0) {
            $children[null] = '<<No data>>';
        }
        foreach ($childrenObj as $child) {
            $children[$child->id] = $child->name;
        }

        return view('partners.components.selectAdministrationUnit', ['name' => $childrenType, 'units' => $children]);
    }
}
