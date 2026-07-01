<!DOCTYPE html>
<html lang="ar" x-data="{ tab: '{{ request()->get('tab', 'login') }}' }">
<head>
    <meta charset="UTF-8">
    <title>Auth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <!-- Tabs -->
        <div class="flex justify-around mb-6">
            <button @click="tab = 'login'"
                :class="tab === 'login' ? 'bg-blue-600 text-white' : 'bg-blue-200 text-black'"
                class="px-4 py-2 rounded">تسجيل دخول</button>
            <button @click="tab = 'register'"
                :class="tab === 'register' ? 'bg-green-600 text-white' : 'bg-green-200 text-black'"
                class="px-4 py-2 rounded">تسجيل جديد</button>
        </div>

        <!-- Login Form -->
        <form x-show="tab === 'login'" action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium">البريد الإلكتروني</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">كلمة المرور</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">دخول</button>
        </form>

        <!-- Register Form -->
        <form x-show="tab === 'register'" action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium">الاسم</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">البريد الإلكتروني</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">كلمة المرور</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">تسجيل</button>
        </form>
    </div>

</body>
</html>
