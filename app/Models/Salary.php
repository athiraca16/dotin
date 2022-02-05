<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'basic_salary',
        'payable_amount',
        'credited_month'
    ];

    /**
     * Get the user record associated with the model.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'employee_id', 'id');
    }
}