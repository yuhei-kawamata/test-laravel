{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', '管理者ダッシュボード')

@section('content')
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">管理者ダッシュボード</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm">総ユーザー数</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm">総タスク数</h3>
        <p class="text-3xl font-bold text-green-600">{{ $totalTasks }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm">完了タスク</h3>
        <p class="text-3xl font-bold text-purple-600">{{ $completedTasks }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-600 text-sm">未着手タスク</h3>
        <p class="text-3xl font-bold text-orange-600">{{ $pendingTasks }}</p>
      </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-xl font-bold mb-4">管理メニュー</h2>
      <a href="{{ route('admin.users') }}" class="text-blue-600 hover:underline">
        ユーザー一覧を見る →
      </a>
    </div>
  </div>
@endsection