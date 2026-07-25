{{-- resources/views/admin/users.blade.php --}}

@extends('layouts.app')

@section('title', 'ユーザー一覧')

@section('content')
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold">ユーザー一覧</h1>
      <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">
        ← ダッシュボードへ戻る
      </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="min-w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">名前</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">メールアドレス</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">権限</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">タスク数</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">登録日</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach ($users as $user)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                  {{ $user->role === 'admin' ? '管理者' : '一般' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">{{ $user->tasks_count }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $user->created_at->format('Y/m/d') }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection