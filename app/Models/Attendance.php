<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

	protected $guarded = [];

	public $timestamps = false;


	public function employee(){
		return $this->belongsTo('Employee::class');
	}

	public function setAttendanceDateAttribute($value)
	{
		$this->attributes['attendance_date'] = Carbon::createFromFormat(session()->get('dateFormat'), $value)->format('Y-m-d');
	}

	public function getAttendanceDateAttribute($value)
	{
		return Carbon::parse($value)->format(session()->get('dateFormat'));
	}
}
