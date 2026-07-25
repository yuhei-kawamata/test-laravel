<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $pendingTasks = Task::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalTasks', 'completedTasks', 'pendingTasks'));
    }

    public function users()
    {
        // ユーザーに紐づくタスク数も取得
        $users = User::withCount('tasks')->latest()->get();
        return view('admin.users', compact('users'));
    }
}
