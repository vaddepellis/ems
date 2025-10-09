<?php

namespace App\Repository\Leave;
use App\Models\Api\Leave;
use Illuminate\Http\Request;

interface LeaveInterface
{
    public function index();
    public function store(Request $request);
    public function show(Leave $leave);
    public function update(Request $request, Leave $leave);
    // public function delete();
}