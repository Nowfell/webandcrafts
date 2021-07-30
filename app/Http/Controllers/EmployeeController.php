<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeFormRequest;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends AdminBaseController
{
    public function __construct()
    {
        $this->pageTitle = "Employees";
        $this->pageIcon = "fas fa-users";
        $this->filter_section = false;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->filter_section = true;
        $this->employees = Employee::all();
        $this->designations = Designation::all();

        return view('admin.employee.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->designations = Designation::all();

        return view('admin.employee.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeFormRequest $request)
    {
        $filenametostore = '';

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->designation_id = $request->designation;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            //get filename with extension
            $filenamewithextension = $image->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $image->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;

            //Upload File
            // $image->storeAs('public/Product Images', $filenametostore);
            $image->move(public_path().'/Photos/', $filenametostore);
        }

        $employee->image = ($filenametostore)?$filenametostore:'';
        $employee->save();

        // $to = $request->email;
        // $subject = 'Created Employee';
        // $message = 'Your Account has been created\n\nPassword: '.$this->randomPassword();
        // mail($to,$subject,$message); //for sending simple mail without smtp

        //Only php mail function supports mailing without smtp, can't provide smtp username and password

        return redirect()->route('admin.employee.index')->with('success','Added Employee Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $this->employee = $employee;
        $this->designations = Designation::all();

        return view('admin.employee.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeFormRequest $request, Employee $employee)
    {
        $filenametostore = '';

        $emp = Employee::findOrFail($employee->id);
        $emp->name = $request->name;
        $emp->email = $request->email;
        $emp->designation_id = $request->designation;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            //get filename with extension
            $filenamewithextension = $image->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $image->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;

            //Upload File
            // $image->storeAs('public/Product Images', $filenametostore);
            File::delete(public_path().'/Photos/'.$employee->image);

            $image->move(public_path().'/Photos/', $filenametostore);

            $emp->image = $filenametostore;
        }

        $emp->save();

        return redirect()->route('admin.employee.index')->with('success','Updated Employee Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::destroy($id);
    }

    public function data(Request $request)
    {
        $employees = Employee::leftJoin('designations', 'employees.designation_id', '=', 'designations.id')
            ->select('employees.id', 'employees.name', 'employees.email', 'employees.image','designations.name as designation_name');

        if ($request->employee_email != 'all' && $request->employee_email != '') {
            $employees = $employees->where('employees.email', $request->employee_email);
        }

        if ($request->employee_name != 'all' && $request->employee_name!= '') {
            $employees = $employees->where('employees.name', $request->employee_name);
        }

        if ($request->employee_designation != 'all' && $request->employee_designation != '') {
            $employees = $employees->where('employees.designation_id', $request->employee_designation);
        }

        $employees = $employees->get();

        return DataTables::of($employees)
            ->addColumn('action', function ($row) {

                $action = '<div class="btn-group dropdown m-r-10">
                <button aria-expanded="false" data-toggle="dropdown" class="btn dropdown-toggle waves-effect waves-light" type="button"><i class="ti-more"></i></button>
                <ul role="menu" class="dropdown-menu pull-right">
                  <li><a href="' . route('admin.employee.edit', [$row->id]) . '"><i class="ti-pencil" aria-hidden="true"></i> Edit</a></li>
                  <li><a href="javascript:;"  data-employee-id="' . $row->id . '"  class="sa-params"><i class="fa fa-times" aria-hidden="true"></i> Delete</a></li>';

                $action .= '</ul> </div>';

                return $action;


            })
            ->editColumn('image', function ($row) {

                $image = '<img src="'.asset('/Photos/'. $row->image) . '" width="40"> ';

                return  ($row->image)?'<div class="row"><div class="col-sm-3 col-xs-4">' . $image . '</div><div class="col-sm-9 col-xs-8">' :' ';
            })
            ->rawColumns(['image', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function randomPassword()
    {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
    }
}
