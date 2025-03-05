@if (session('success'))
                <div id="success-alert"
                    class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>

                <script>
                    setTimeout(function() {
                        document.getElementById("success-alert").style.display = "none";
                    }, 3000); // 3000 ms = 3 detik (Bisa diubah sesuai kebutuhan)
                </script>
            @endif