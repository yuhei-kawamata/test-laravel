{{-- resources/views/tasks/index.blade.php --}}

@extends('layouts.app')

@section('title', 'タスク一覧')

@section('content')
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">タスク一覧</h1>
    <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
      ＋ 新規タスク作成
    </a>
  </div>

  {{-- 検索・フィルタ --}}
  <div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap gap-4">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="キーワード検索"
        class="flex-1 min-w-[200px] px-3 py-2 border border-gray-300 rounded">

      <select name="status" class="px-3 py-2 border border-gray-300 rounded">
        <option value="">ステータス: すべて</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>未着手</option>
        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>進行中</option>
        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>完了</option>
      </select>

      <select name="priority" class="px-3 py-2 border border-gray-300 rounded">
        <option value="">優先度: すべて</option>
        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>低</option>
        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>中</option>
        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>高</option>
      </select>

      <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        検索
      </button>
      <a href="{{ route('tasks.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
        クリア
      </a>
    </form>
  </div>

  {{-- タスク一覧 --}}
  @if($tasks->count() > 0)
    <div class="space-y-4">
      @foreach($tasks as $task)
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-1 text-xs rounded
                                          {{ $task->getPriorityColor() == 'high' ? 'bg-red-100 text-red-800' : '' }}
                                          {{ $task->getPriorityColor() == 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                          {{ $task->getPriorityColor() == 'low' ? 'bg-green-100 text-green-800' : '' }}">
                  優先度: {{ $task->getPriorityLabel() }}
                </span>
                <span class="px-2 py-1 text-xs rounded
                                          {{ $task->getStatusColor() == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                          {{ $task->getStatusColor() == 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                          {{ $task->getStatusColor() == 'pending' ? 'bg-gray-100 text-gray-800' : '' }}">
                  {{ $task->getStatusLabel() }}
                </span>
                @if($task->isOverdue())
                  <span class="px-2 py-1 text-xs rounded bg-red-600 text-white">期限切れ</span>
                @endif
              </div>

              <h3 class="text-lg font-bold text-gray-800 mb-2">
                <a href="{{ route('tasks.show', $task) }}" class="hover:text-blue-600">
                  {{ $task->title }}
                </a>
              </h3>

              @if($task->description)
                <p class="text-gray-600 mb-2">{{ Str::limit($task->description, 100) }}</p>
              @endif

              <div class="text-sm text-gray-500">
                @if($task->due_date)
                  <span>期限: {{ $task->due_date->format('Y年m月d日') }}</span>
                @endif
                @if(auth()->user()->isAdmin())
                  <span class="ml-4">作成者: {{ $task->user->name }}</span>
                @endif
              </div>
            </div>

            {{-- 画像サムネイル --}}
            @if($task->image)
              <img src="{{ $task->getImageUrl() }}" alt="タスク画像" class="w-24 h-24 object-cover rounded ml-4">
            @endif
          </div>

          {{-- アクション --}}
          <div class="flex gap-2 mt-4">
            @if($task->user_id == auth()->id() && !$task->isCompleted())
              <form method="POST" action="{{ route('tasks.complete', $task) }}">
                @csrf
                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">
                  ✓ 完了にする
                </button>
              </form>
            @endif

            @if($task->user_id == auth()->id())
              <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                編集
              </a>
            @endif

            @if($task->user_id == auth()->id() || auth()->user()->isAdmin())
              <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline"
                onsubmit="return confirm('本当に削除しますか？')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                  削除
                </button>
              </form>
            @endif
          </div>
        </div>
      @endforeach
    </div>

    {{-- ページネーション --}}
    <div class="mt-6">
      {{ $tasks->links() }}
    </div>
  @else
    <div class="bg-white rounded-lg shadow p-8 text-center">
      <p class="text-gray-600">タスクがありません。新しいタスクを作成しましょう！</p>
    </div>
  @endif
@endsection