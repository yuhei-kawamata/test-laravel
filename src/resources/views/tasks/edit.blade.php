{{-- resources/views/tasks/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'タスク編集')

@section('content')
  <div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">タスク編集</h1>

    @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- 現在の画像表示と削除ボタン --}}
    @if($task->image)
      <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">現在の画像</h2>
        <img src="{{ $task->getImageUrl() }}" alt="現在の画像" class="w-48 h-48 object-cover rounded mb-4">
        <form method="POST" action="{{ route('tasks.delete-image', $task) }}" onsubmit="return confirm('画像を削除しますか？')">
          @csrf
          @method('DELETE')
          <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
            画像を削除
          </button>
        </form>
      </div>
    @endif

    {{-- タスク編集フォーム --}}
    <form method="POST" action="{{ route('tasks.update', $task) }}" enctype="multipart/form-data"
      class="bg-white rounded-lg shadow p-6">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          タイトル <span class="text-red-500">*</span>
        </label>
        <input type="text" name="title" value="{{ old('title', $task->title) }}"
          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          説明
        </label>
        <textarea name="description" rows="4"
          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $task->description) }}</textarea>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          ステータス <span class="text-red-500">*</span>
        </label>
        <select name="status"
          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          required>
          <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>未着手</option>
          <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>進行中</option>
          <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>完了</option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          優先度 <span class="text-red-500">*</span>
        </label>
        <select name="priority"
          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          required>
          <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>低</option>
          <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>中</option>
          <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>高</option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          期限
        </label>
        <input type="date" name="due_date"
          value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          画像 {{ $task->image ? '（新しい画像に変更）' : '' }}
        </label>
        <input type="file" name="image" accept="image/*"
          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p class="text-gray-500 text-xs mt-1">
          {{ $task->image ? '新しい画像をアップロードすると、現在の画像が置き換わります。' : 'JPEG, PNG, GIF形式（最大2MB）' }}
        </p>
      </div>

      <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
          更新
        </button>
        <a href="{{ route('tasks.index') }}"
          class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400 transition">
          キャンセル
        </a>
      </div>
    </form>
  </div>
@endsection