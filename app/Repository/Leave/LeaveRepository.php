<?php
namespace App\Repository\Leave;

use DateTime;
use App\Models\Api\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\LeaveResource;
use App\Repository\Leave\LeaveInterface;
use Illuminate\Support\Facades\Validator;

class LeaveRepository implements LeaveInterface
{
    public function index()
    {
        if (Gate::denies('viewAny', Leave::class)) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to view this leave request.',
            ], 403);
        }

        $user = Auth::user();
        $leaves = $user->isAdmin() ? Leave::all() : $user->leaves()->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Leaves fetched successfully!',
            'data'    => [
                'leaves' => LeaveResource::collection($leaves),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string',
            'discription' => 'required|string',
            'from' => 'required|string',
            'to' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $exists = Leave::where('user_id', auth()->id())
            ->where(function ($query) use ($request) {
                $query->whereDate('from', $request->from)
                    ->orWhereDate('to', $request->to);
            })->exists();

        if ($exists) {
            return response()->json(['status' => 'error', 'message' => 'Leave already applied'], 409);
        }

        $from = new DateTime($request->from);
        $to = new DateTime($request->to);
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
        $leave->refresh();
        return response()->json([
            'status' => 'success',
            'message' => 'Leave applied successfully',
            'data' => [
                'leave' => new LeaveResource($leave),
            ],
        ], 201);
    }

    public function show(Leave $leave)
    {
        if (Gate::denies('view', $leave)) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to view this leave request.',
            ], 403);
        }

        $leave->load('user');

        return response()->json([
            'status' => 'success',
            'message' => 'Leave fetched successfully!',
            'leave' => new LeaveResource($leave),
        ]);
    }

    public function update(Request $request, Leave $leave)
    {
        if (Gate::denies('update', $leave)) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to update this leave request.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'reason' => 'required|string',
            'discription' => 'required|string',
            'from' => 'required|string',
            'to' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $from = new DateTime($request->from);
        $to = new DateTime($request->to);
        $diffInDays = $from->diff($to)->days + 1;

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
        ]);
    }
}
