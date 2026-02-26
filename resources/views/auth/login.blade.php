<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lumino Logistics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(99, 102, 241, 0.3); }
            50% { box-shadow: 0 0 40px rgba(99, 102, 241, 0.6); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        .pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.2);
        }
        
        .btn-hover {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-hover:hover::before {
            left: 100%;
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.3);
        }
        
        .hidden { display: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex items-center justify-center gradient-bg">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-40 float-animation"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-100 rounded-full mix-blend-multiply filter blur-xl opacity-40 float-animation" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-purple-100 rounded-full mix-blend-multiply filter blur-xl opacity-40 float-animation" style="animation-delay: 4s;"></div>
    </div>

    <!-- Main Login Container -->
    <div class="relative z-10 w-full max-w-md mx-4">
        <!-- Logo Section -->
        <div class="text-center mb-8 float-animation">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-2xl shadow-2xl pulse-glow mb-4">
                <img src="{{ asset('images/newlogo.svg') }}" alt="Lumino Logistics" class="w-16 h-16">
            </div>
            @if(session('login_otp'))
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Verify OTP</h1>
                <p class="text-slate-600">Enter the 6-digit code sent to your email</p>
            @else
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Welcome Back</h1>
                <p class="text-slate-600">Sign in to your Lumino Logistics account</p>
            @endif
        </div>

        <!-- Login/OTP Form -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-800">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(session('login_otp'))
                <!-- OTP Form -->
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-blue-600">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 4L12 14.01l-3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-sm text-slate-600">We sent a code to <strong>{{ session('login_otp_email') }}</strong></p>
                </div>

                <form action="{{ route('auth.verify-otp') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- OTP Input -->
                    <div class="space-y-2">
                        <label for="otp" class="block text-sm font-medium text-slate-700">OTP Code</label>
                        <input 
                            type="text" 
                            id="otp" 
                            name="otp" 
                            maxlength="6" 
                            pattern="[0-9]{6}"
                            class="w-full px-4 py-3 text-center text-2xl font-mono border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="000000"
                            required
                            autocomplete="one-time-code"
                        >
                        <p class="text-xs text-slate-500">Enter the 6-digit code from your email</p>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="btn-hover w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span>Verify OTP</span>
                    </button>
                </form>

                <!-- Resend OTP -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-slate-600 mb-3">Didn't receive the code?</p>
                    <form action="{{ route('auth.resend-otp') }}" method="POST" class="inline">
                        @csrf
                        <button 
                            type="submit" 
                            class="text-sm text-blue-600 hover:text-blue-500 font-medium transition-colors"
                        >
                            Resend OTP
                        </button>
                    </form>
                </div>

                <!-- Back to Login -->
                <div class="mt-4 text-center">
                    <a href="{{ route('auth.login') }}" class="text-sm text-slate-600 hover:text-slate-800 transition-colors">
                        ← Back to login
                    </a>
                </div>
            @else
                <!-- Login Form -->
                <form action="{{ route('auth.login') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-slate-700">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                class="input-focus w-full pl-10 pr-3 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Enter your email"
                            >
                        </div>
                        <p id="emailError" class="text-red-500 text-sm hidden"></p>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-slate-700">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                class="input-focus w-full pl-10 pr-10 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Enter your password"
                            >
                            <button 
                                type="button" 
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                            >
                                <svg id="eyeIcon" class="h-5 w-5 text-slate-400 hover:text-slate-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <svg id="eyeOffIcon" class="h-5 w-5 text-slate-400 hover:text-slate-600 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        <p id="passwordError" class="text-red-500 text-sm hidden"></p>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="btn-hover w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span id="btnText">Sign In</span>
                        <span id="btnLoading" class="flex items-center justify-center hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Signing in...
                        </span>
                    </button>
                </form>

                <!-- Sign Up Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-slate-600">
                        Don't have an account? 
                        <a href="{{ route('auth.register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                            Sign up here
                        </a>
                    </p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-slate-500 text-sm">
                2024 Lumino Logistics. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInput = document.getElementById('otp');
            let pastedCode = false;
            
            // Refresh CSRF token periodically to prevent expiration
            setInterval(function() {
                fetch('/csrf-token', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update all CSRF tokens in the form
                    document.querySelectorAll('input[name="_token"]').forEach(input => {
                        input.value = data.token;
                    });
                })
                .catch(error => console.log('CSRF refresh failed:', error));
            }, 300000); // Refresh every 5 minutes
            
            // OTP Input functionality
            if (otpInput) {
                console.log('OTP input found, setting up manual submit for paste');
                
                // Auto-format OTP input
                otpInput.addEventListener('input', function(e) {
                    console.log('OTP input changed:', this.value);
                    
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');
                    
                    // Auto-submit when 6 digits entered (but not if pasted)
                    if (this.value.length === 6 && !pastedCode) {
                        console.log('6 digits entered manually, submitting form');
                        // Small delay to ensure the value is set
                        setTimeout(() => {
                            this.form.submit();
                        }, 100);
                    }
                });

                // Prevent paste of non-numeric characters and disable auto-submit
                otpInput.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pasteData = (e.clipboardData || window.clipboardData).getData('text');
                    const numericData = pasteData.replace(/[^0-9]/g, '').slice(0, 6);
                    
                    // Set flag to indicate code was pasted
                    pastedCode = true;
                    
                    // Insert the numeric data
                    document.execCommand('insertText', false, numericData);
                    
                    console.log('OTP code pasted, manual verification required');
                    
                    // Reset flag after a short delay
                    setTimeout(() => {
                        pastedCode = false;
                    }, 1000);
                });
                
                // Reset pasted flag when user starts typing manually
                otpInput.addEventListener('keydown', function(e) {
                    if (e.key !== 'v' && e.key !== 'V' && !e.ctrlKey && !e.metaKey) {
                        pastedCode = false;
                    }
                });
            } else {
                console.log('OTP input not found');
            }
        });
    </script>
</body>
</html>