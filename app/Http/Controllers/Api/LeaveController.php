<?php

namespace App\Http\Controllers\Api;

use DateTime;
use App\Models\Api\Leave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\LeaveResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LeaveController extends Controller implements HasMiddleware{
    use AuthorizesRequests;

    public static function  middleware(){
        return [
            // new Middleware('auth:sanctum', except: ['index', 'show'])
            new Middleware('auth:sanctum')
        ];
    }
    public function index(){
        if(Gate::denies('viewAny',Leave::class)){
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to view this leave request.',
            ], 403);
        }
        $user = Auth::user();

        $leaves = $user->isAdmin() ? Leave::all() :$user->leaves()->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Leaves fetched successfully!',
            'data'    => [
                'leaves' => LeaveResource::collection($leaves),
            ],
        ], 200);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string',
            'discription' => 'required|string',
            'from'=>'required|string',
            'to' => 'required|string',
            
        ] );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        $exists = Leave::where('user_id',auth()->id())
            ->where(function($query) use ($request){
                $query->whereDate('from',$request->from)
                ->orWhereDate('to',$request->to);
            })->exists();
        if($exists){
            return response()->json(['status'=>'error','message'=>'leave already applied'],409);
        }
        $from = new DateTime($request->from);
        $to = new DateTime($request->to);
        $interval = $from->diff($to);
        $diffInDays = $interval->days + 1; //including end date;
        $leave = Leave::create([
            'user_id'=>auth()->id(),
            'reason' => $request->reason,         
            'discription' => $request->discription,
            'from' => $request->from,
            'to' => $request->to,
            'updated_by'=>auth()->id(),
            'leave_value'=>$diffInDays
        ]);
        $leave->refresh();

        return response()->json([
            'status' => 'success',
            'message' => 'Leave appllied successfully',
            'data' => [
                'leave' => new LeaveResource($leave),
            ],
        ], 201);
    }
    public function show(Leave $leave){
        if(Gate::denies('view',$leave)){
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to view this leave request.',
            ], 403);
        }
        $leave->load('user');
        return response()->json([
            'status'=>'success',
            'message'=>'leaves fetched successfully!',
            'leave'=>new LeaveResource($leave)
        ],200);
    }
    public function update(Request $request,Leave $leave){
        
        if(Gate::denies('update', $leave)){
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to update this leave request.',
            ], 403);
        }
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string',
            'discription' => 'required|string',
            'from'=>'required|string',
            'to' => 'required|string',
            
        ] );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $from = new DateTime($request->from);
        $to = new DateTime($request->to);
        $interval = $from->diff($to);
        $diffInDays = $interval->days + 1; //including end date;
        $update = [
            'reason'       => $request->reason,         
            'discription'  => $request->discription,
            'from'         => $request->from,
            'to'           => $request->to,
            'leave_value'  => $diffInDays,
            'updated_by'   => auth()->id(),
        ];
        if (auth()->user()->isAdmin() && $request->has('status')) {
            $update['leave_status'] = $request->status;
        }
        $leave->update($update);
        $leave->refresh();

        return response()->json([
            'status' => 'success',
            'message' => 'Leave updated successfully',
            'data' => [
                'leave' => new LeaveResource($leave),
            ],
        ], 200);
    }

}
