<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClinicFlow - Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#F0F9FF',
                            100: '#E6F7FB',
                            500: '#68D6EC',
                            600: '#4BC9E3',
                        },
                        secondary: {
                            500: '#3B82F6',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7fb 100%);
        }
        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        .wave svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 70px;
        }
        .wave .shape-fill {
            fill: #68D6EC;
            opacity: 0.2;
        }
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .error-message {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        .error-message.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-md mx-auto">
            
            <!-- Card -->
            <div class="bg-white rounded-xl card-shadow overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-primary-500 to-primary-600 py-6 px-8 text-center">
                    <i data-feather="key" class="w-12 h-12 mx-auto text-white"></i>
                    <h1 class="text-2xl font-bold text-white mt-4">Reset Your Password</h1>
                    <p class="text-primary-100 mt-2">Enter your email to receive a password reset link</p>
                </div>
                
                <!-- Form -->
                <div class="p-8">
                    <form method="POST" action="#" id="passwordResetForm">
                        <!-- CSRF Token (simulated for demo) -->
                        <input type="hidden" name="_token" value="demo-csrf-token">
                        
                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-feather="mail" class="text-gray-400"></i>
                                </div>
                                <input id="email" type="email" name="email" required autocomplete="email" autofocus
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200"
                                    placeholder="your@email.com">
                            </div>
                            <!-- Error message container -->
                            <div id="emailError" class="error-message mt-2">
                                <p class="text-red-500 text-xs"></p>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center shadow-md hover:shadow-lg">
                            <i data-feather="send" class="mr-2"></i> Send Password Reset Link
                        </button>
                    </form>

                    <div class="mt-6 text-center">
<a href="{{ url('admin') }}" class="text-primary-500 hover:text-primary-600 font-medium flex items-center justify-center">
    <i data-feather="arrow-left" class="mr-1"></i> Back to Login
</a>
                    </div>
                </div>
            </div>
            
            <!-- Help text -->
            <div class="mt-6 text-center text-gray-500 text-sm">
                <p>Need help? <a href="#" class="text-primary-500 hover:text-primary-600 font-medium">Contact our support team</a></p>
            </div>
        </div>
    </div>

    <!-- Wave animation -->
    <div class="wave">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
        </svg>
    </div>

    <script>
        feather.replace();
        
        // Form validation
        document.getElementById('passwordResetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const emailError = document.getElementById('emailError');
            const errorMessage = emailError.querySelector('p');
            
            // Reset error state
            emailError.classList.remove('show');
            errorMessage.textContent = '';
            
            // Simple validation
            if (!email) {
                errorMessage.textContent = 'Email address is required.';
                emailError.classList.add('show');
                return;
            }
            
            if (!isValidEmail(email)) {
                errorMessage.textContent = 'Please enter a valid email address.';
                emailError.classList.add('show');
                return;
            }
            
            // If validation passes, show success message
            alert('Password reset link has been sent to your email!');
            // In a real application, you would submit the form here
        });
        
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        // Wave animation
        document.addEventListener('DOMContentLoaded', function() {
            const wave = document.querySelector('.wave svg path');
            
            // Reset animation
            anime.set(wave, {
                translateX: 0
            });
            
            // Animate the wave
            anime({
                targets: wave,
                translateX: [0, -30],
                easing: 'easeInOutSine',
                duration: 5000,
                loop: true,
                direction: 'alternate'
            });
        });
    </script>
</body>
</html>