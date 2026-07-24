<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    
    // タスクの一覧表示（検索、ページネーション機能付）
    public function index(Request $request)
    {
        // Taskデータベースを使って検索するための準備
        $query = Task::query();

        // ログインユーザーに紐づくタスクのみを表示
        // 管理者はユーザー情報も一緒に取得
        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->with('user');
        }

        // ステータスフィルタ
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 優先度フィルタ
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // キーワード検索
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like' , '%' . $request->search . '%')
                    ->orwhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // 未完了タスク（'completed'が０）⇒完了タスク（'completed'が１）の順
        // 期限が近い順、期限が同じ場合は作成日時が新しい順に並べる
        $query->orderByRaw("CASE WHEN status = 'completed' THEN 1 ELSE 0 END")
            ->orderBy('due_date', 'asc')
            ->orderBy('created_at', 'desc');

        // withQueryString()があることで、ページ遷移しても検索条件が保持されたままになる
        $tasks = $query->paginate(10)->withQueryString();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after_or_equal:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 画像アップロード処理
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tasks', 'public');
        }

        auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'タスクを作成しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if ($task->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'このタスクの閲覧権限がありません。');
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'このタスクの編集権限がありません。');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'このタスクの更新権限がありません。');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 画像アップロード処理
        if ($request->hasFile('image')) {

            // 古い画像を削除
            if($task->image) {
                Storage::disk('public')->delete($task->image);
            }
            $validated['image'] = $request->file('image')->store('tasks', 'public');
        }
        
        // ステータスが完了に変わった場合、完了日時（'completed_at'）を設定
        if ($validated['status'] === 'completed' && $task->status !== 'completed') {
            $validated['completed_at'] = now();
        } elseif ($validated['status'] !== 'completed') {
            $validated['completed_at'] = null;
        }

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'タスクを更新しました！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'このタスクの削除権限がありません。');
        }

        // 画像も削除する
        if ($task->image) {
            Storage::disk('public')->delete($task->image);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'タスクを削除しました！');
    }

    public function complete(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'このタスクを完了にする権限がありません。');
        }

        // Taskモデル内で定義した関数を呼び出している
        $task->markAsCompleted();

        return back()->with('success', 'タスクを完了しました！');
    }

    public function deleteImage(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'このタスクの画像を削除する権限がありません。');
        }

        if($task->image) {
            Storage::disk('public')->delete($task->image);
            $task->update(['image' => null]);
        }

        return back()->with('success', '画像を削除しました！');
    }
}
