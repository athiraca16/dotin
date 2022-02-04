<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\EmployeeLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * list all  employees
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function index()
    {
        
        $user = User::with('leaves')->get();

        return UserResource::collection($user);
    }
    /**
     * save employee
     *
     * @param  UserBasicRequest $request
     *
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->validated();

        if ($input['password']) {
            $input['password'] = bcrypt($input['password']);
        }
        User::create($input);


        return response()->noContent();
    }

    /**
     * Show  employee
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);

            return (new UserResource($user));
        } catch (\Exception $e) {
            return response()->json('error' . $e->getMessage(), 422);
        }
    }
     /**
     * calculate salary
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function calculateSalary($id,$month)
    {
            $user   = User::find($id);
            $salary = $user->salary;
            $leave  = EmployeeLeave::where('employee_id',$user->id)->first();
            
           
    } 
    
}
