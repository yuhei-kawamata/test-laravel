<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'TODOアプリ')</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
  {{-- ナビゲーション --}}
  <nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <a href="{{ route('tasks.index') }}" class="text-xl font-bold text-blue-600">
            📝 TODOアプリ
          </a>
        </div>
        <div class="flex items-center gap-4">
          @auth
            <span class="text-gray-700">{{ auth()->user()->name }}</span>
            @if(auth()->user()->isAdmin())
              <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded">管理者</span>
            @endif
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="text-gray-600 hover:text-gray-900">
                ログアウト
              </button>
            </form>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  {{-- フラッシュメッセージ --}}
  @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
      </div>
    </div>
  @endif

  {{-- メインコンテンツ --}}
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @yield('content')
  </main>
</body>

</html>