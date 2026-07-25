{{-- resources/views/tasks/create.blade.php --}}

@extends('layouts.app')

@section('title', 'タスク作成')

@section('content')
  <div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">新規タスク作成</h1>

    @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data"
      class="bg-white rounded-lg shadow p-6">
      @csrf

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          タイトル <span class="text-red-500">*</span>
        </label>
        <input type="text" name="title" value="{{ old('title') }}"
          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          説明
        </label>
        <textarea name="description" rows="4"
          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          優先度 <span class="text-red-500">*</span>
        </label>
        <select name="priority"
          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          required>
          <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>低</option>
          <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>中</option>
          <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>高</option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          期限
        </label>
        <input type="date" name="due_date" value="{{ old('due_date') }}" min="{{ date('Y-m-d') }}"
          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          画像（任意）
        </label>
        <input type="file" name="image" accept="image/*"
          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p class="text-gray-500 text-xs mt-1">
          JPEG, PNG, GIF形式（最大2MB）
        </p>
      </div>

      <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
          作成
        </button>
        <a href="{{ route('tasks.index') }}"
          class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400 transition">
          キャンセル
        </a>
      </div>
    </form>
  </div>
@endsection