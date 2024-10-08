<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Checker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <img src="{{ asset('assets/img/logo.png') }}" alt="login" class="w-[80px] h-[80px] sm:w-[100px] sm:h-[100px] mx-auto">
        <h2 class="text-2xl font-bold text-center mb-6"></h2>

        <form action="{{ route('password.check') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-md font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-300" required>
            </div>

            <div>
                <label for="password" class="block text-md font-medium text-gray-700">Password</label>
                <label class="block text-sm text-blue-700  font-bold"><br><span class="text-red-500">Note: <span>Password must begin with "@"</label>
                
                <div class="relative">
                    <input type="password" name="password" id="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-300" required>

                    <i id="eyeIcon" class="fa fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500" onclick="togglePassword()"></i>
                </div>

            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300">
                Register
            </button>
        </form>

        <div class="py-4">
            @if ($errors->any())
                <div class="bg-red-100 text-red-500 p-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li><i class="fa fa-times"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 text-green-500 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
