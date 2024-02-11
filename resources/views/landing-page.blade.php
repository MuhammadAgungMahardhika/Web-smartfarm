<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartFarm - Peternakan Ayam Broiler</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f5e7e7;
            color: #333;
            transition: background-color 0.5s ease;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: linear-gradient(to right, #e4aeae, #f0c6c6);
            /* Warna latar belakang dengan gradasi */
            color: #fff;
            text-align: center;
        }

        header h1 {
            color: #fff;
            margin: 0;
            font-size: 3em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            /* Efek bayangan pada teks */
        }

        nav {
            text-align: center;
            background: linear-gradient(to right, #e4aeae, #f0c6c6);
            /* Warna latar belakang dengan gradasi */
            padding: 10px;
            overflow: hidden;
        }

        nav a {
            color: #333;
            /* Warna teks */
            text-decoration: none;
            padding: 14px 20px;
            display: inline-block;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #fff;
            /* Warna teks saat di-hover */
        }

        .menu-icon {
            display: none;
            cursor: pointer;
            font-size: 1.5em;
            color: #fff;
            float: right;
            margin-top: 12px;
        }

        .menu-icon:hover {
            color: #e4aeae;
            /* Warna ikon saat di-hover */
        }

        .menu-links {
            display: inline-block;
            float: right;
        }

        @media screen and (max-width: 768px) {
            nav a {
                display: block;
                width: 100%;
                text-align: center;
            }

            .menu-icon {
                display: block;
            }

            .menu-links {
                display: none;
                width: 100%;
                text-align: center;
            }

            .menu-links.active {
                display: block;
            }
        }

        section.hero {
            position: relative;
            height: 60vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            /* Mengubah arah tata letak menjadi kolom */
            align-items: center;
            justify-content: center;
            background: url('/images/bg/farm.jpg') no-repeat center center/cover;
            color: #fff;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            /* Efek bayangan pada teks */
        }

        section.hero:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        section.hero h1,
        section.hero p,
        .cta-button {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 1s ease, transform 1s ease;
        }

        .cta-button {
            display: inline-block;
            background: #e4aeae;
            /* Warna tombol */
            color: #fff;
            padding: 15px 30px;
            text-decoration: none;
            font-size: 3em;
            /* Ukuran teks tombol */
            border-radius: 5px;
            transition: background 0.3s ease, color 0.3s ease;
            z-index: 2;
            cursor: pointer;
            margin-top: 20px;
        }

        .cta-button:hover {
            background: #f0c6c6;
            /* Warna tombol saat di-hover */
        }

        section.features {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            padding: 50px 20px;
        }

        .feature {
            flex: 0 0 calc(33.333% - 40px);
            margin: 20px;
            text-align: center;
        }

        .feature img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .feature img:hover {
            transform: scale(1.1);
        }

        .feature h3 {
            font-size: 2em;
            /* Ukuran teks judul fitur */
            color: #e4aeae;
            /* Warna judul fitur */
            margin-bottom: 10px;
        }

        .feature p {
            font-size: 1em;
            color: #555;
        }

        footer {
            background: #333;
            color: #e4aeae;
            /* Warna teks footer */
            text-align: center;
            padding: 20px;
        }

        .scroll-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #e4aeae;
            /* Warna tombol scroll to top */
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: none;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .scroll-to-top:hover {
            background: #f0c6c6;
            /* Warna tombol saat di-hover */
        }
    </style>
</head>

<body>

    <header>

        {{-- <a href=""><img src="{{ asset('/images/logo/smartfarm2.png') }}" alt="Logo" style="width: 5em"></a> --}}
        <h1>SmartFarm</h1>

        <div class="menu-icon" onclick="toggleMenu()">☰</div>
        <nav class="menu-links">
            <?php if(Auth::check()): ?>
            <a href="/menuList">Menu List</a>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <?php else: ?>
            <a href="/login">Login</a>
            {{-- <a href="/register">Daftar</a> --}}
            <?php endif; ?>
        </nav>
    </header>

    <section class="hero" id="home">
        <h1 style="color:#ffff; z-index:999; font-size: 3.5em">Revolutionize Your Broiler Farming</h1>
        <p style="color:#fff; z-index:999; font-size: 1em">Empowering Livestock Farming Through Innovative Technology
        </p>

    </section>

    <section class="features" id="features">
        <div class="feature">
            <img src="/images/bg/precision.jpg" alt="Precision Farming">
            <h3>Precision Farming</h3>
            <p>Increase results with data-driven insights. Optimize resource utilization for maximum efficiency.</p>
        </div>
        <div class="feature">
            <img src="/images/bg/monitoring.jpg" alt="Remote Monitoring">
            <h3>Remote Monitoring</h3>
            <p>Monitor your farm from anywhere in real-time. Receive notifications about your farm information in
                real-time.</p>
        </div>
    </section>

    <footer>
        &copy; 2023 SmartFarm. All rights reserved.
    </footer>

    <div class="scroll-to-top" onclick="scrollToTop()">↑ Back to Top.</div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            animateHeroSection();
        });

        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.querySelector('.scroll-to-top').style.display = "block";
            } else {
                document.querySelector('.scroll-to-top').style.display = "none";
            }
        }

        function scrollToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        function animateHeroSection() {
            setTimeout(function() {
                document.querySelector('.hero h1').style.opacity = 1;
                document.querySelector('.hero h1').style.transform = 'translateY(0)';
            }, 500);
            setTimeout(function() {
                document.querySelector('.hero p').style.opacity = 1;
                document.querySelector('.hero p').style.transform = 'translateY(0)';
            }, 800);

        }

        function toggleMenu() {
            const menuLinks = document.querySelector('.menu-links');
            menuLinks.classList.toggle('active');
        }
    </script>

</body>

</html>
