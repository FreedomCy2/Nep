<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cancel Booking | Clinic Flow</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico" />
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
        body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }
        .btn-primary {
            background-color: #3b82f6;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <i data-feather="heart" class="text-primary h-8 w-8"></i>
                <span class="ml-2 text-xl font-bold text-gray-800">Clinic Flow</span>
            </div>
        </div>
    </div>
</nav>

<!-- Cancel Booking Section -->
<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden p-10 text-center">
        <h1 class="text-4xl font-extrabold text-primary mb-6">Cancel Booking</h1>

        @if(isset($booking))
            <p class="mb-8 text-gray-700 text-lg">
                Are you sure you want to cancel your booking with ID: <span class="font-semibold">{{ $booking->id }}</span>?
            </p>
            <p class="mb-6 text-gray-600">
                Booking Date: <span class="font-medium">{{ $booking->date }}</span><br />
                Booking Time: <span class="font-medium">{{ $booking->time }}</span><br />
                Doctor: <span class="font-medium">{{ $booking->doctor_name }}</span>
            </p>

            <form method="POST" action="{{ route('booking.cancel', ['id' => $booking->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-primary text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition w-full">
                    Confirm Cancel Booking
                </button>
            </form>

            <a href="{{ route('introduction') }}" class="inline-block mt-6 text-primary hover:underline">
                &larr; Go Back
            </a>
        @else
            <p class="text-red-500 text-lg">No booking found to cancel.</p>
            <a href="{{ route('user.introduction') }}" class="inline-block mt-6 text-primary hover:underline">
                &larr; Go Back
            </a>
        @endif
    </div>
</main>

<!-- Footer -->
<footer class="bg-gray-800 mt-16">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center text-gray-400">
        &copy; 2025 Clinic Flow. All rights reserved.
    </div>
</footer>

<!-- Scripts -->
<script>
    feather.replace();
</script>

</body>
</html>
