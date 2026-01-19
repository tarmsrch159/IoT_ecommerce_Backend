<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark'=> ($appearance ?? 'system') == 'dark'])>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Inline script to detect system dark mode preference and apply it immediately --}}
    <script>
        (function() {
            const appearance = '{{ $appearance ?? "system" }}';

            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();
    </script>

    {{-- Inline style to set the HTML background color based on our theme in app.css --}}
    <style>
        html {
            background-color: oklch(1 0 0);
        }

        /* html.dark {
            background-color: oklch(0.145 0 0);
        } */
    </style>

    <title>Ecomm IoT NuxtJS - @yield('title')</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="font-sans antialiased bg-slate-100">
    <!-- Alpine wrapper -->
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">

        <!-- Header -->
        @include('admin.layouts.header')

        <!-- Overlay -->
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/40 z-40 md:hidden">
        </div>


        <div class="flex">

            @include('admin.layouts.sidebar')

            <main class="flex-1 p-6">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- Sweet alert js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    @if (session('success'))
    <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500
        });
    </script>
    @endif


    @if (session('error'))
    <script>
        Swal.fire({
            position: "top-end",
            icon: "error",
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2500
        });
    </script>
    @endif

    <script>
        function deleteItem(id) {
            Swal.fire({
                title: "คุณแน่ใจ ใช่มั้ย?",
                text: "คุณจะไม่สามารถย้อนกลับได้!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ใช่, ลบเดี๋ยวนี้!",
                cancelButtonText: "ยกเลิก"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(id).submit();
                }
            });
        }
    </script>

    <script>
        //Function สำหรับส่งinput ของรุปแต่ละรูปและ path image แต่ละอัน
        function handleImageInputChange(input, image) {
            const inputEl = document.getElementById(input);
            const imageEl = document.getElementById(image);

            if (!inputEl || !imageEl) return; // ⭐ สำคัญที่สุด

            inputEl.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imageEl.classList.remove('hidden');
                        imageEl.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        // เรียกใช้ฟังก์ชันสำหรับ input แต่ละอัน
        handleImageInputChange('logo', 'logo_preview');
        handleImageInputChange('thumbnail', 'thumbnail_preview');
    </script>

   
</body>

</html>