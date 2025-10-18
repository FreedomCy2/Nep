<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Profile | Clinic Flow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }
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
<body class="flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white shadow-sm px-6 py-4 flex justify-end">
        <a href="{{ route('user.booking') }}" class="text-[#3b82f6] font-semibold hover:underline mr-6">Bookings</a>
        <a href="{{ route('user.profile') }}" class="text-[#3b82f6] font-semibold hover:underline">Profile</a>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-10 rounded-lg shadow-lg max-w-lg w-full">

            <h1 class="text-3xl font-bold mb-8 text-[#3b82f6] text-center">Your Profile</h1>

            <!-- Profile Picture -->
            <div class="flex flex-col items-center mb-8">
                @if(isset($user->profile_picture))
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="w-32 h-32 rounded-full object-cover mb-4 border-4 border-primary">
                @else
                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mb-4 text-gray-400 text-6xl font-bold">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>
                @endif

                <form method="POST" action="{{ route('user.profile') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="profile_picture" accept="image/*" class="mb-4" required />
                    <button type="submit" class="btn-primary text-white px-6 py-2 rounded-lg font-semibold shadow hover:shadow-lg transition">
                        Upload Picture
                    </button>
                </form>
            </div>

            <!-- User Info and Edit Form -->
            <form method="POST" action="{{ route('user.profile') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-gray-700 mb-1 font-semibold">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required
                        class="w-full border-gray-300 rounded-lg p-3 focus:ring-primary focus:border-primary" />
                </div>

                <div>
                    <label for="email" class="block text-gray-700 mb-1 font-semibold">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                        class="w-full border-gray-300 rounded-lg p-3 focus:ring-primary focus:border-primary" />
                </div>

                <div>
                    <label for="phone" class="block text-gray-700 mb-1 font-semibold">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                        class="w-full border-gray-300 rounded-lg p-3 focus:ring-primary focus:border-primary" />
                </div>

                <button type="submit" class="btn-primary text-white w-full px-6 py-3 rounded-lg font-semibold shadow hover:shadow-lg transition">
                    Save Changes
                </button>
            </form>

        </div>
    </main>

</body>
</html>
