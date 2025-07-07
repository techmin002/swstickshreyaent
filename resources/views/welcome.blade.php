<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <svg class="h-12 w-auto text-[#FF2D20]" viewBox="0 0 62 65" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M25 0L50 15V50L25 65L0 50V15L25 0Z" fill="currentColor" />
                </svg>
            </div>
            <!-- Register -->
            {{-- @if (Route::has('register'))
                <div class="text-center mt-4">
                    <a href="{{ route('register') }}"
                        class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                        Don't have an account? Register
                    </a>
                </div>
            @endif --}}

            <!-- Heading -->
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-2">Welcome Back</h2>
            <p class="text-sm text-center text-gray-500 dark:text-gray-300 mb-6">Login to access your account</p>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                    <input type="email" id="email" name="email" required autofocus
                        class="mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-[#FF2D20] focus:outline-none dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Password -->
                <div>
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-[#FF2D20] focus:outline-none dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="h-4 w-4 text-[#FF2D20] border-gray-300 rounded focus:ring-[#FF2D20]">
                    <label for="remember" class="ml-2 block text-sm text-gray-600 dark:text-gray-300">
                        Remember me
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full py-2 px-4 bg-[#FF2D20] hover:bg-red-600 text-white font-semibold rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF2D20]">
                    Login
                </button>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <div class="text-center mt-4">
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                            Forgot your password?
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</body>

</html>
