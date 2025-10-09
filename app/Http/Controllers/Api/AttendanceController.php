<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Api\Attendance;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Repository\Attendance\AttendanceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttendanceController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;
    protected $attendaceRepository;

    public function __construct(AttendanceInterface $attendace){
        $this->attendaceRepository = $attendace;
    }
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }
    public function index(Request $request){
        return $this->attendaceRepository->index($request);
    }
    public function store(Request $request){
        return $this->attendaceRepository->store($request);
    }
    public function show(Attendance $attendance){
        return $this->attendaceRepository->show($attendance);
    }
    public function update(Request $request,Attendance $attendance){
        return $this->attendaceRepository->update($request,$attendance);
    }
    public function destroy(Request $request,Attendance $attendance){
        return $this->attendaceRepository->delete($request,$attendance);
    }
}
