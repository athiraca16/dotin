<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeLeaveRequest;
use App\Http\Resources\EmployeeLeave as EmployeeLeaveResources;
use App\Models\EmployeeLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
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
        $user = Auth::user();

        $leave = EmployeeLeave::get();

        return EmployeeLeaveResources::collection($leave);
    }
    /**
     * save employee
     *
     * @param  EmployeeLeaveRequest $request
     *
     * @return Response
     */
    public function store(EmployeeLeaveRequest $request)
    {
        $input = $request->validated();

        $user = Auth::user();

        EmployeeLeave::create($input);

        return response()->noContent();
    }
    
}