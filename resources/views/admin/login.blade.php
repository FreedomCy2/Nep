<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clinic Flow</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
            border-radius: 12px;
            overflow: hidden;
        }
        
        .login-left {
            background: linear-gradient(135deg, #68D6EC 0%, #4a9ff5 100%);
        }
        
        .error-message {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .btn-primary {
            background-color: #68D6EC;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #4a9ff5;
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        
        .form-input:focus {
            border-color: #68D6EC;
            box-shadow: 0 0 0 3px rgba(104, 214, 236, 0.2);
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto login-container">
            <div class="flex flex-col md:flex-row">
                <!-- Left Side - Branding -->
                <div class="md:w-1/2 login-left text-white p-10 flex flex-col justify-center">
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <i data-feather="activity" class="mr-3 text-white text-3xl"></i>
                            <h1 class="text-3xl font-bold">Clinic Flow</h1>
                        </div>
                        <p class="text-lg opacity-90">Streamline your clinic management with our comprehensive solution.</p>
                    </div>
                    
                    <div class="mt-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                                <i data-feather="calendar" class="text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">Appointment Management</h3>
                                <p class="text-sm opacity-80">Easily schedule and track patient appointments</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center mb-6">
                            <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                                <i data-feather="users" class="text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">Patient Records</h3>
                                <p class="text-sm opacity-80">Secure and organized patient information</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                                <i data-feather="bar-chart" class="text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">Analytics & Reports</h3>
                                <p class="text-sm opacity-80">Gain insights into clinic performance</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Login Form -->
                <div class="md:w-1/2 bg-white p-10">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-800">Welcome Back</h2>
                        <p class="text-gray-600 mt-2">Sign in to your account</p>
                    </div>
                    
                    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Display Laravel Validation Errors -->
                        @if($errors->any())
                            <div class="error-message">
                                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i data-feather="alert-triangle" class="text-red-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Display Success Message -->
                        @if(session('success'))
                            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i data-feather="check-circle" class="text-green-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-feather="mail" class="text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-input block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#68D6EC] focus:border-[#68D6EC]" placeholder="you@example.com">
                            </div>
                        </div>
                        
                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-feather="lock" class="text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password" required class="form-input block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#68D6EC] focus:border-[#68D6EC]" placeholder="••••••••">
                            </div>
                        </div>
                        
                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-[#68D6EC] focus:ring-[#68D6EC] border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                            </div>
                            
                            <div class="text-sm">
                                <a href="{{ route('admin.password.request') }}" class="font-medium text-[#68D6EC] hover:text-[#4a9ff5]">Forgot your password?</a>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="btn-primary w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#68D6EC]">
                                Sign in
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-600">
                            Don't have an account?
                            <a href="{{ route('admin.register') }}" class="font-medium text-[#68D6EC] hover:text-[#4a9ff5]">Register</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Feather icons
        feather.replace();
        
        // Add shake animation on form errors
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form');
                form.classList.add('error-message');
                setTimeout(() => {
                    form.classList.remove('error-message');
                }, 500);
            });
        @endif
    </script>
</body>
</html>