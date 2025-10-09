<?php

namespace App\Http\Controllers;

use App\Models\Api\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LeaveController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;
    protected $leaveRepo;

   
     public static function middleware()
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    public function index(){
        $user = Auth::user();
        $leaves = $user->isAdmin() ? Leave::all() : $user->leaves()->get();
        return view('leave.index',compact('leaves'));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string',
            'discription' => 'required|string',
            'from' => 'required|string',
            'to' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validation failed');
        }

        $exists = Leave::where('user_id', auth()->id())
            ->where(function ($query) use ($request) {
                $query->whereDate('from', $request->from)
                    ->orWhereDate('to', $request->to);
            })->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with(['error'=>'Leave already applied','leave'=>Leave::class]);
        }

        $from = new \DateTime($request->from);
        $to = new \DateTime($request->to);
        $diffInDays = $from->diff($to)->days + 1;

        $leave = Leave::create([
            'user_id'     => auth()->id(),
            'reason'      => $request->reason,
            'discription' => $request->discription,
            'from'        => $request->from,
            'to'          => $request->to,
            'leave_value' => $diffInDays,
            'updated_by'  => auth()->id(),
        ]);

        return redirect()->back()
            ->with('success', 'Leave applied successfully');
    }
    public function show(Leave $leave)
    {
        return view('leave.create',compact('leave'));
    }
    public function edit(){
        return [];
    }
    public function update(){

    }
    public function destroy(){

    }
}
