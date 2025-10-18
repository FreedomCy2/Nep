<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClinicFlow</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#10b981',
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .hero-bg {
            background-image: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)),
                              url('http://static.photos/medical/1200x630/42');
            background-size: cover;
            background-position: center;
        }
        .btn-primary { transition: all 0.3s ease; }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i data-feather="heart" class="text-primary h-8 w-8"></i>
                        <span class="ml-2 text-xl font-bold text-gray-800">ClinicFlow</span>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="#" class="border-primary text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                    <a href="{{ route('user.aboutus') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Services</a>
                    <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Doctors</a>
                    <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Contact</a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <!-- Navigation Book Appointment Button -->
                    <a href="{{ route('user.bookings') }}" class="bg-primary hover:bg-primary-600 text-white px-4 py-2 rounded-md text-sm font-medium btn-primary">
                        Book Appointment
                    </a>
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                        <span class="sr-only">Open main menu</span>
                        <i data-feather="menu"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-bg">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                    <span class="block">Your Health is</span>
                    <span class="block text-primary">Our Priority</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Comprehensive healthcare services tailored to your needs with compassionate professionals dedicated to your wellbeing.
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8 space-x-3">
                    <a href="{{ route('user.bookings') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-600 md:py-4 md:text-lg md:px-10 btn-primary">
                        Book an Appointment
                    </a>
                    <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                        Our Services
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Services</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Comprehensive Healthcare Solutions</p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    We offer a wide range of medical services to meet all your healthcare needs.
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="relative">
                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary-500 text-white">
                        <i data-feather="activity"></i>
                    </div>
                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Diagnostics</p>
                    <p class="mt-2 ml-16 text-base text-gray-500">State-of-the-art diagnostic equipment for accurate and timely results.</p>
                </div>
                <div class="relative">
                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary-500 text-white">
                        <i data-feather="heart"></i>
                    </div>
                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Cardiology</p>
                    <p class="mt-2 ml-16 text-base text-gray-500">Comprehensive heart care from prevention to advanced treatments.</p>
                </div>
                <div class="relative">
                    <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary-500 text-white">
                        <i data-feather="eye"></i>
                    </div>
                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Ophthalmology</p>
                    <p class="mt-2 ml-16 text-base text-gray-500">Expert eye care for vision correction and eye health management.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <p class="text-gray-400 text-center">&copy; 2023 ClinicFlow. All rights reserved.</p>
        </div>
    </footer>

    <script>
        feather.replace();
    </script>
</body>
</html>
