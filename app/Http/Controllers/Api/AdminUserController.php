<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use DB;
use Carbon\Carbon;

class AdminUserController extends Controller
{
    /**
     * salary info
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function index()
    {
        $salary = Salary::where('status',0)->select(
            DB::raw('sum(basic_salary) as totalSalary'),
            DB::raw('sum(payable_amount) as totalPayableAmount'),
        )->first();
        return response()->json( $salary);
    }
    /**
     * update status after payment
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function updateStatus($id)
    {
        $salary = Salary::find($id);
        $salary->status = 1;
        $salary->save();
    }
}
