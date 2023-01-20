<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PositionController extends Controller
{
    public function index(Request $request)
    {
    if ($request->ajax()) {
        $data = Position::select('id','name', 'updated_at');
        return Datatables::of($data)->addIndexColumn()
        ->addColumn('action', function($data){
                $button = '<a href="/admin/positions/'. $data->id .'/edit"  class="edit btn btn-primary btn-sm"> <i class="fas fa-fw fa-edit"></i>Edit</a>';
                $button .= '        <button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"">
                 <i class="fas fa-fw fa-trash"></i> Delete</button>';
                return $button;
            })->make(true);
    }

    return view('admin.positions.index');

}

public function create(){
    return view('admin.positions.create');
}

public function post(StorePositionRequest $request){
    $input = $request->validated();

    $result = Position::create([
        'name' => $request->input('name'),
        'admin_created_id' => auth()->id(),
        'admin_updated_id' => auth()->id(),
    ]);

    return to_route('admin.positions.index');
}

public function edit($id){
    $position = Position::findOrFail($id);
    return view('admin.positions.edit', compact('position'));
}

public function update(StorePositionRequest $request, $id){
    $input = $request->validated();

    $position = Position::findOrFail($id);

    $position->update([
        'name' => $request->input('name'),
        'admin_updated_at' => auth()->id(),
    ]);

    return to_route('admin.positions.index');

}

public function destroy($id)
{
    $data = Position::findOrFail($id);
    $data->delete();
}
}
