{{-- resources/views/tasks/show.blade.php --}}

@extends('layouts.app')

@section('title', $task->title)

@section('content')
  <div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
      {{-- ステータスバッジ --}}
      <div class="flex items-center gap-2 mb-4">
        <span class="px-3 py-1 text-sm rounded
                      {{ $task->getPriorityColor() == 'high' ? 'bg-red-100 text-red-800' : '' }}
                      {{ $task->getPriorityColor() == 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                      {{ $task->getPriorityColor() == 'low' ? 'bg-green-100 text-green-800' : '' }}">
          優先度: {{ $task->getPriorityLabel() }}
        </span>
        <span class="px-3 py-1 text-sm rounded
                      {{ $task->getStatusColor() == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                      {{ $task->getStatusColor() == 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                      {{ $task->getStatusColor() == 'pending' ? 'bg-gray-100 text-gray-800' : '' }}">
          {{ $task->getStatusLabel() }}
        </span>
        @if($task->isOverdue())
          <span class="px-3 py-1 text-sm rounded bg-red-600 text-white">期限切れ</span>
        @endif
      </div>

      {{-- タイトル --}}
      <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $task->title }}</h1>

      {{-- メタ情報 --}}
      <div class="text-sm text-gray-600 mb-6 space-y-1">
        <p>作成者: {{ $task->user->name }}</p>
        <p>作成日: {{ $task->created_at->format('Y年m月d日 H:i') }}</p>
        @if($task->due_date)
          <p>期限: {{ $task->due_date->format('Y年m月d日') }}</p>
        @endif
        @if($task->completed_at)
          <p>完了日時: {{ $task->completed_at->format('Y年m月d日 H:i') }}</p>
        @endif
      </div>

      {{-- 画像 --}}
      @if($task->image)
        <div class="mb-6">
          <img src="{{ $task->getImageUrl() }}" alt="{{ $task->title }}" class="w-full max-w-lg rounded-lg shadow">
        </div>
      @endif

      {{-- 説明 --}}
      @if($task->description)
        <div class="mb-6">
          <h2 class="text-xl font-bold text-gray-800 mb-2">説明</h2>
          <p class="text-gray-700 whitespace-pre-wrap">{{ $task->description }}</p>
        </div>
      @endif

      {{-- アクションボタン --}}
      <div class="flex gap-4 mt-8">
        @if($task->user_id == auth()->id() && !$task->isCompleted())
          <form method="POST" action="{{ route('tasks.complete', $task) }}">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
              ✓ 完了にする
            </button>
          </form>
        @endif

        @if($task->user_id == auth()->id())
          <a href="{{ route('tasks.edit', $task) }}"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            編集
          </a>
        @endif

        @if($task->user_id == auth()->id() || auth()->user()->isAdmin())
          <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline"
            onsubmit="return confirm('本当に削除しますか？')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
              削除
            </button>
          </form>
        @endif

        <a href="{{ route('tasks.index') }}"
          class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400 transition">
          一覧に戻る
        </a>
      </div>
    </div>
  </div>
@endsection