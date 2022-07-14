<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use App\Models\Department;
use App\Models\TestType;
use App\Models\TestTypeValue;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class PageController extends Controller
{
    public function index(){
        $departments = Department::all();
        $testTypes = TestType::all();
//        $result = TestType::select(DB::raw("
//        SELECT test_types.name,SUM(test_type_values.amount) as amount FROM test_types LEFT JOIN test_type_values on test_type_values.test_type_id = test_types.id GROUP BY test_types.id
//        "));


        if (auth()->user()->role == 0){
            $recentData = TestTypeValue::latest('id')->limit(5)->get();
        }else{
            $recentData = TestTypeValue::where('user_id',auth()->id())->latest('id')->limit(5)->get();
        }

        if (auth()->user()->role == 0){
            $data = TestTypeValue::when(isset(request()->department),function ($q){
                $department = request()->department;
                $q->where('department_id','=',$department);
            })->when(isset(request()->testType),function ($qy){
                $testType = request()->testType;
                $qy->where('test_type_id','=',$testType);
            })->when(isset(request()->start_date),function ($query){
                $startDate = request()->start_date;
                $endDate = request()->end_date;
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })->select('amount','created_at')->whereBetween('created_at', [Carbon::now()->subMonth(4), Carbon::now()])->get()->groupBy(function ($data){
                return Carbon::parse($data->created_at)->format('M');
            });
        }else{
            $data = TestTypeValue::when(isset(request()->department),function ($q){
                $department = request()->department;
                $q->where('department_id','=',$department);
            })->when(isset(request()->testType),function ($qy){
                $testType = request()->testType;
                $qy->where('test_type_id','=',$testType);
            })->when(isset(request()->start_date),function ($query){
                $startDate = request()->start_date;
                $endDate = request()->end_date;
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })->where('user_id',auth()->id())->select('amount','created_at')->whereBetween('created_at', [Carbon::now()->subMonth(4), Carbon::now()])->get()->groupBy(function ($data){
                return Carbon::parse($data->created_at)->format('M');
            });
        }

        $months = [];
        $monthCount = [];

        foreach ($data as $month => $values){
            $months[] = $month;
            $monthCount[] = count($values);
        }

        return view('index',['departments'=>$departments,'testTypes'=>$testTypes,'data'=>$data,'months'=>$months,'monthCount'=>$monthCount,'recentData'=>$recentData]);
    }

    public function listing(){
        $departments = Department::all();
        $testTypes = TestType::all();

        if (auth()->user()->role == 0){
            $testData = TestTypeValue::when(isset(request()->department),function ($q){
                $department = request()->department;
                $q->where('department_id','=',$department);
            })->when(isset(request()->testType),function ($qy){
                $testType = request()->testType;
                $qy->where('test_type_id','=',$testType);
            })->when(isset(request()->start_date),function ($query){
                $startDate = request()->start_date;
                $endDate = request()->end_date;
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })->latest('id')->paginate(10);
        }else{
            $testData = TestTypeValue::when(isset(request()->department),function ($q){
                $department = request()->department;
                $q->where('department_id','=',$department);
            })->when(isset(request()->testType),function ($qy){
                $testType = request()->testType;
                $qy->where('test_type_id','=',$testType);
            })->when(isset(request()->start_date),function ($query){
                $startDate = request()->start_date;
                $endDate = request()->end_date;
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })->where('user_id',auth()->id())->latest('id')->paginate(10);
        }

        $sum = TestTypeValue::when(isset(request()->department),function ($q){
            $department = request()->department;
            $q->where('department_id','=',$department);
        })->when(isset(request()->testType),function ($qy){
            $testType = request()->testType;
            $qy->where('test_type_id','=',$testType);
        })->when(isset(request()->start_date),function ($query){
            $startDate = request()->start_date;
            $endDate = request()->end_date;
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })->sum('amount');
        return view('listing',['departments'=>$departments,'testTypes'=>$testTypes,'testTypeValues'=>$testData,'sum'=>$sum]);
    }


    public function users(){
        $users = User::where('role','1')->get();
        return view('users',compact('users'));
    }

    // custom user register
    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect()->back()->with('status',"Successfully Created!");
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function destroy($id){
        $currentUser = User::findOrFail($id);
        $currentName = $currentUser->name;
        $currentUser->delete();
        return redirect()->back()->with('success',$currentName." Successfully Deleted!");

    }

    // changing user to admin
    public function makeAdmin(Request $request){
        $currentUser = User::findOrFail($request->id);
        if ($currentUser->role == 1){
            $currentUser->role = '0';
            $currentUser->update();
        }
        return redirect()->back()->with('success',$currentUser->name." has been changed to Admin");
    }


    public function testTypeByDepartment(Request $request){

        $request->validate([
           'department' => 'required|integer|exists:departments,id'
        ]);

        $testTypes = TestType::where('department_id',$request->department)->get();
        return view('test_value.form',compact('testTypes'));
    }

    // export data with excel
    public function getTestValueData(){
        $department = request()->department;
        $startDate = \request()->start_date;
        $endDate = \request()->end_date;
        return Excel::download(new DataExport($department,$startDate,$endDate), 'လချုပ်စာရင်း.xlsx');
    }

    // 404 Page
    public function denied(){
        return view('denied');
    }

}
