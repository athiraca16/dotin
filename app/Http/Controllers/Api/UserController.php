<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\EmployeeLeave;
use App\Models\Salary;
use Carbon\Carbon;
use DB;
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
    public function calculateSalary($id, $month)
    {
        $user   = User::find($id);
        $salary = $user->salary;
        $employeeLeave  = EmployeeLeave::where('employee_id', $user->id)->latest('updated_at')->first();
        $leaveMonth = $employeeLeave->month;
        $date =  Carbon::parse($leaveMonth)->format('m');
        $currentMonth = Carbon::parse($month)->format('m');

        if ($date == $currentMonth) {

            $days =  Carbon::parse($leaveMonth)->daysInMonth;
            if ($employeeLeave->leave > 1) {
                $presentDay = $days - ($employeeLeave->leave);
                $employeeSalary = ($salary / $days) * $presentDay;
            } else {
                $employeeSalary = $salary;
            }
            Salary::create([
                'employee_id' => $user->id,
                'basic_salary' => $salary,
                'payable_amount' => round($employeeSalary),
                'credited_month' => $leaveMonth,
            ]);
            return response()->json(round($employeeSalary));
        }
        $employeeSalary = $salary;


        return response()->json(round($employeeSalary));
    }
}
