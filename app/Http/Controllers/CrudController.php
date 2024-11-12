<?php

namespace App\Http\Controllers;

use App\Models\countriesModel;
use DataTables;
use App\Models\CrudModel;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class CrudController extends Controller
{
    public function index(){
        // not in work
        return view('welcome',compact('countries'));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'            =>  'required',
            'email'           =>  'required',
            'country_id_fk'   =>  'required',
            'address'         =>  'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 200);
        }
        $users = CrudModel::where('id',$request->id)->pluck('id')->toArray();
        if($users){
            $data                  = CrudModel::where('id',$request->id)->first();
            $data->name            = $request->name;
            $data->email           = $request->email;
            $data->country_id_fk   = $request->country_id_fk;
            $data->address         = $request->address;
            $data->status          = $request->status;
            // dd($data);
            $data->save();
        }else{

            $data = new CrudModel;
            $data->name           = $request->name;
            $data->email          = $request->email;
            $data->country_id_fk  = $request->country_id_fk;
            $data->address        = $request->address;
            $data->status         = $request->status;
            $data->save();
        }
                return response()->json(['success'=>true,'message'=>'Data store successfully']);
            
    }
    public function show(Request $request){
        $data = CrudModel::query();

        if($request->ajax()){
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at',function($data){
                    return $data->created_at->diffForHumans();
                })
                ->editColumn('country_id_fk',function($data){
                    return $data->country->countries_name;
                })
                
                ->addColumn('status',function($data){
                    return $data->status == 1 ? 'Active' : 'Inactive';
                })
                ->addColumn('action', function($data){
                    return '<a href="javascript:void(0)" class="btn btn-primary btn-sm edituser" data-id="'.$data->id.'">Edit</a>
                            <a href="javascrip:void(0)" data-id="'.$data->id.'" class="btn btn-danger btn-sm deleteuser">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
    }
        function edit($id){
        $data = CrudModel::find($id);
        return response()->json($data);
    }
    
    function delete($id){
        $data = CrudModel::find($id);
        $data->delete();
        return response()->json(['success'=>true,'User delete successfully']);


    }
}
