<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Propaganistas\LaravelPhone\PhoneNumber;
use Image;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::with('position')->select('id','name','email', 'position_id', 'image_path', 'recruitment_date',
            'phone_number', 'payment');
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('position', function (Employee $employee) {
                return $employee->position->name;
            })->addColumn('image_path', function ($data) { $url=asset("images/$data->image_path");
                return '<img src='.$url.' class="rounded-circle" width="40" align="center" />'; })
            ->addColumn('action', function($data){
                    $button = '<a href="/admin/employees/'. $data->id .'/edit"  class="edit btn btn-primary btn-sm"> <i class="fas fa-fw fa-edit"></i>Edit</a>';
                    $button .= '        <button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"">
                     <i class="fas fa-fw fa-trash"></i> Delete</button>';
                    return $button;
                })->rawColumns(['image_path', 'action'])
                ->make(true);
        }

        return view('admin.employees.index');

    }

    public function create(){
        $positions= Position::select('id', 'name')->get();
        return view('admin.employees.create', compact('positions'));
    }

    public function search(Request $request){
        $query = $request->get('query');
        $filterResult = Employee::where('name', 'LIKE', '%'. $query. '%')->get();
        return response()->json($filterResult);
    }

    public function post(StoreEmployeeRequest $request){
        $input = $request->validated();

        if ($image = $request->file('image_path')) {
                $image_destination_path = 'images/';
                $employee_image = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($image_destination_path, $employee_image);
                $img = Image::make($image_destination_path . $employee_image)->resize(300, 300);

                // save file as jpg with medium quality
                $deleteImage = unlink(public_path(). '/images/' . $employee_image);
                $img->encode('jpg')->save('images/'. date('YmdHis') . '.jpg', 80);
                $input['image_path'] = date('YmdHis') . '.jpg';
        } else {
            $input['image_path'] = 'profile.jpg';
        }

        $head = Employee::where('name', $input['head_id'])->first();

        if (empty($head)){
            $head_id = null;
        } else {
            $head_id = $head->id;
        }

        $phone = PhoneNumber::make($request->input('phone_number'), 'UA');

        $result = Employee::create([
            'name' => $request->input('name'),
            'position_id' => $request->input('position_id'),
            'phone_number' => $phone->formatInternational(),
            'recruitment_date' => $request->input('recruitment_date'),
            'email' => $request->input('email'),
            'head_id' => $head_id,
            'image_path' => $input['image_path'],
            'payment' => number_format($request->input('payment')),
            'admin_created_id' => auth()->id(),
            'admin_updated_id' => auth()->id(),
        ]);

        return to_route('admin.employees.index');
    }

    public function edit($id){
        $employee = Employee::findOrFail($id);
        $positions= Position::select('id', 'name')->get();
        return view('admin.employees.edit', compact('positions', 'employee'));
    }

    public function update(StoreEmployeeRequest $request, $id){
        $input = $request->validated();

        $employee = Employee::findOrFail($id);

        if ($request->has('image_path')) {
            $image = $request->file('image_path');
            if ($employee->image_path != 'profile.jpg'){
                $deleteImage = unlink(public_path(). '/images/' . $employee->image_path);
            }
                $image_destination_path = 'images/';
                $employee_image = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($image_destination_path, $employee_image);

                $img = Image::make($image_destination_path . $employee_image)->resize(300, 300);

                // save file as jpg with medium quality
                $delete_image = unlink(public_path(). '/images/' . $employee_image);
                $img->encode('jpg')->save('images/'. date('YmdHis') . '.jpg', 80);
                $input['image_path'] = date('YmdHis') . '.jpg';
        } else {
            $input['image_path'] = "$employee->image_path";
        }

        $phone = PhoneNumber::make($request->input('phone_number'), 'UA');

        $head = Employee::where('name', $input['head_id'])->first();

        if (empty($head)){
            $head_id = null;
        } else {
            $head_id = $head->id;
        }

        $employee->update([
            'name' => $request->input('name'),
            'position_id' => $request->input('position_id'),
            'phone_number' => $phone->formatInternational(),
            'recruitment_date' => $request->input('recruitment_date'),
            'email' => $request->input('email'),
            'head_id' => $head_id,
            'image_path' => $input['image_path'],
            'payment' => number_format($request->input('payment')),
            'admin_updated_id' => auth()->id(),
        ]);

        return to_route('admin.employees.index');

    }

    public function destroy($id)
    {
        $data = Employee::findOrFail($id);
        if ($data->image_path != 'profile.jpg'){
            $deleteImage = unlink(public_path(). '/images/' . $data->image_path);
        }
        $data->delete();
    }

}

