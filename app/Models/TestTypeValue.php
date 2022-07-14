<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestTypeValue extends Model
{
    use HasFactory;

    protected $with = ['user','department','testType'];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function testType(){
        return $this->belongsTo(TestType::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    // local scope filter
//    public function scopeFilter($q){
//        if (isset(request()->department)){
//            $department = request()->department;
//            $q->where('department_id','=',$department);
//        }elseif (isset(request()->testType)){
//            $testType = request()->testType;
//            $q->where('test_type_id','=',$testType);
//        }
//    }

}
