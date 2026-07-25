<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録 - TODOアプリ</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
  <div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
      <h2 class="text-2xl font-bold text-center mb-6">📝 TODOアプリ 新規登録</h2>

      @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">名前</label>
          <input type="text" name="name" value="{{ old('name') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            required autofocus>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">メールアドレス</label>
          <input type="email" name="email" value="{{ old('email') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">パスワード</label>
          <input type="password" name="password"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
        </div>

        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2">パスワード（確認）</label>
          <input type="password" name="password_confirmation"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
          登録
        </button>

        <p class="text-center mt-4 text-sm text-gray-600">
          既にアカウントをお持ちの方は
          <a href="{{ route('login') }}" class="text-blue-600 hover:underline">ログイン</a>
        </p>
      </form>
    </div>
  </div>
</body>

</html>