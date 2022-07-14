<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\TestType;
use App\Models\TestTypeValue;
use App\Http\Requests\StoreTestTypeValueRequest;
use App\Http\Requests\UpdateTestTypeValueRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class TestTypeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        return view('test_value.index',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('denied');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTestTypeValueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestTypeValueRequest $request)
    {
        $validation = Validator::make($request->all(),[
            'department_id' => 'required|integer|exists:departments,id',
            'test_type_id' => 'required|integer|exists:test_types,id',
            'amount' => 'required|integer'
        ]);

        if ($validation->fails()){
            return response()->json([
                'status' => "Fail",
                'errors' => $validation->errors()
            ]);
        }

        $testTypeValue = new TestTypeValue();
        $testTypeValue->amount = $request->amount;
        $testTypeValue->department_id = $request->department_id;
        $testTypeValue->test_type_id = $request->test_type_id;
        $testTypeValue->user_id = Auth::id();
        $testTypeValue->save();

        return response()->json([
            'status' => 'success',
            'info' => $testTypeValue
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestTypeValue  $testTypeValue
     * @return \Illuminate\Http\Response
     */
    public function show(TestTypeValue $testTypeValue)
    {
        return redirect()->route('denied');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestTypeValue  $testTypeValue
     * @return \Illuminate\Http\Response
     */
    public function edit(TestTypeValue $testTypeValue)
    {
        return redirect()->route('denied');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTestTypeValueRequest  $request
     * @param  \App\Models\TestTypeValue  $testTypeValue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestTypeValueRequest $request,$id)
    {

        $validation = Validator::make($request->all(),[
            'department' => 'required|integer|exists:departments,id',
            'test_type' => 'required|integer|exists:test_types,id',
            'amount' => 'required|integer'
        ]);

        if ($validation->fails()){
            return response()->json([
                'status' => "Fail",
                'errors' => $validation->errors()
            ]);
        }

        $testTypeValue = TestTypeValue::findOrFail($id);
        $testTypeValue->amount = $request->amount;
        $testTypeValue->test_type_id = $request->test_type;
        $testTypeValue->department_id = $request->department;
        $testTypeValue->user_id = Auth::id();
        $testTypeValue->update();

        return redirect()->back()->with('status','Successfully Updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestTypeValue  $testTypeValue
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testTypeValue = TestTypeValue::findOrFail($id);
        Gate::allows('delete',$testTypeValue);
        $testTypeValue->delete();
        return redirect()->back()->with('status','Successfully Deleted!');
    }
}
