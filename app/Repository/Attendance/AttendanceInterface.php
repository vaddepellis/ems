<?php

namespace App\Repository\Attendance;

use App\Models\Api\Attendance;
use Illuminate\Http\Request;

interface AttendanceInterface
{
    public function index(Request $request);
    public function store(Request $request);
    public function show(Attendance $attendance);
    public function update(Request $request,Attendance $attendance);
    public function delete(Request $request,Attendance $attendance);
}
