<?php

namespace App\Repository\Attendance;

use Illuminate\Http\Request;
use App\Models\Api\Attendance;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AttendanceResource;
use App\Repository\Attendance\AttendanceInterface;

class AttendanceRepository implements AttendanceInterface
{
    /**
     * Create a new class instance.
     */
    
    public function index(Request $request){
        if (Gate::denies('viewAny', Attendance::class)) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to view attendance records.',
            ], 403);
        }
        $user = auth()->user();

        if ($user->isAdmin()) {
            $attendance = Attendance::where('in_date', date('Y-m-d'))->get();
            if($attendance){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Records found.',
                    'data'  =>AttendanceResource::collection($attendance)
                ], 200);
            }
            else{
                return response()->json([
                'status' => 'error',
                'message' => 'no records found.',
            ], 403);
            }
        } else {
            $attendance = Attendance::where('in_date',now()->format('Y-m-d'))->where('user_id', $user->id)->first();

            if ($attendance) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'records found.',
                    'data'  =>new AttendanceResource($attendance)
                ], 200);
            } else {
                return response()->json([ 'status' => 'error','message' => 'No records found.','data'=>[]], 404);
            }
        }
    }

    public function store(Request $request){
        if(Gate::denies('create',Attendance::class)){
            return response()->json([
                'status'=>'error',
                'message'=>'you are not authorized'
            ],403);
        }
        $exists = $request->user()->attendance()->where('in_date', date('Y-m-d'))->first();
        if($exists){
            return response()->json(new AttendanceResource($exists),201);
        }
        $attendance = $request->user()->attendance()->create([
            'in_date'   => now()->format('Y-m-d'),
            'in_time'   => now()->format('H:i'),
        ]);
        $attendance->refresh();
        return response()->json(new AttendanceResource($attendance),201);
    }


    public function show(Attendance $attendance){
        if(Gate::denies('view',$attendance)){
            return response()->json([
                'status'=>'error',
                'message'=>'you are not authorized'
            ],403);
        }
        return response()->json(new AttendanceResource($attendance));
    }
    public function update(Request $request,Attendance $attendance){
        if(Gate::denies('update',$attendance)){
            return response()->json([
                'status'=>'error',
                'message'=>'you are not authorized'
            ],403);
        }
        $attendance->update([
            'out_time' => now()->format('H:i')
        ]);
        return response()->json(new AttendanceResource($attendance),200);
    }
    public function delete(Request $request,Attendance $attendance){
        if (Gate::denies('delete', $attendance)) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to update this leave request.',
            ], 403);
        }
        $attendance->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'attendance deleted',
        ], 200);

    }
}
