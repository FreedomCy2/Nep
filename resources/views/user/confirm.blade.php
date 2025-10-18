<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Booking Confirmation | Clinic Flow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- Top Navigation with Profile Link -->
    <nav class="bg-white shadow-sm px-6 py-4 flex justify-end">
        <a href="{{ route('user.profile') }}" class="text-[#3b82f6] font-semibold hover:underline">Profile</a>
    </nav>

    <!-- Main Content Centered -->
    <div class="flex-grow flex items-center justify-center">
        <div class="bg-white p-10 rounded-lg shadow-lg max-w-md w-full text-center">
            <h1 class="text-3xl font-bold mb-4 text-[#3b82f6]">Booking Confirmed!</h1>
            
            @if(isset($information))
                <p class="mb-6 text-gray-700">
                    Thank you, <strong>{{ $information['name'] ?? 'Guest' }}</strong>, your appointment for <strong>{{ $information['service'] ?? 'Service' }}</strong> is confirmed on <strong>{{ $information['date'] ?? 'Date' }}</strong>.
                </p>
            @else
                <p class="mb-6 text-gray-700">Thank you for your booking. We will contact you soon.</p>
            @endif
            
            <div class="flex justify-center gap-4">
                <a href="{{ route('user.booking') }}" class="inline-block px-6 py-3 bg-[#3b82f6] text-white rounded-lg hover:bg-[#2563eb] transition">
                    Edit Booking
                </a>
                <a href="{{ route('user.cancel') }}" class="inline-block px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Cancel Booking
                </a>
            </div>
        </div>
    </div>
    
</body>
</html>
