<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Leave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Leave\LeaveInterface;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LeaveController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    protected $leaveRepo;

    public function __construct(LeaveInterface $leaveRepo)
    {
        $this->leaveRepo = $leaveRepo;
    }

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    public function index()
    {
        return $this->leaveRepo->index();
    }

    public function store(Request $request)
    {
        return $this->leaveRepo->store($request);
    }

    public function show(Leave $leave)
    {
        return $this->leaveRepo->show($leave);
    }

    public function update(Request $request, Leave $leave)
    {
        return $this->leaveRepo->update($request, $leave);
    }
}
