<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agung's Collection</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://kit.fontawesome.com/f076b04045.js" crossorigin="anonymous"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Amaranth:ital,wght@0,400;0,700;1,400;1,700&family=Yatra+One&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=IM+Fell+English+SC&display=swap');

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            padding-top: 70px;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
        }

        header {
            background-color: #252525;
            color: #fff;
            padding: 10px 0;
            border-bottom: 1px solid #131313;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
        }

        header.scrolled {
            background-color: rgba(139, 0, 0, 0.95);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            padding: 8px 0;
        }

        header .logo {
            transition: all 0.3s ease-in-out;
        }

        header.scrolled .logo {
            width: 70px;
        }

        nav li {
            transition: font-size 0.3s ease-in-out;
        }

        header.scrolled nav li {
            font-size: 14px;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav li {
            margin: 0 18px;
            font-family: "Amaranth", sans-serif;
            font-weight: 400;
            font-size: 15px;
        }

        nav a {
            color: #fff;
        }

        nav a:hover {
            color: #e44949;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer {
            font-family: 'Amaranth', sans-serif;
            background-color: #530000;
            color: white;
            text-align: center;
            padding: 20px 0;
            bottom: 0;
            width: 100%;
            font-size: 14px;
            margin-top: 50px;
        }

        .logo {
            width: 100px;
        }

        .logo img {
            width: 100px;
            margin-left: auto;
            margin-right: auto;
            display: block;
            border-radius: 5px;
        }

        .artikel h2 {
            text-align: center;
            font-family: 'Amaranth', sans-serif;
            font-weight: bold;
            font-size: 25px;
            color: #800000;
            width: 80%;
            margin: 0 auto;
            padding-top: 60px;
        }

        .artikel .cover {
            display: block;
            margin: 40px auto;
            text-align: center;
            font-family: 'Amaranth', sans-serif;
            color: #800000;
            width: 40%;
            border: 4px solid rgb(90, 90, 90);
        }

        .artikel .cover img {
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 5px;
        }

        .artikel .konten {
            width: 80%;
            display: block;
            margin: 0 auto;
            text-align: justify;
            font-size: 15px;
            font-weight: normal;
            margin-bottom: 50px;
        }

        .artikel .konten p img {
            max-width: 30%;
            display: block;
            margin: 0 auto;
            text-align: justify;
            border: 2px solid rgb(90, 90, 90);
        }

        .detail {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 80%;
            margin: 0 auto;
            font-family: 'Amaranth', sans-serif;
            font-size: 15px;
            color: #800000;
            margin-top: 20px;
        }

        .penulis {
            margin: 0;
        }

        .tanggal {
            margin: 0;
        }

        body {
            background-image: url("{{ asset('images/bg.jpg') }}");
        }

        main {
            background-color: rgba(243, 244, 246, 0.95);
        }
    </style>
</head>
<body>
    <main>
    <header>
        <div class="container">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
            <nav>
                <ul>
                    <li><a href="/#beranda">Beranda</a></li>
                    <li><a href="/#tentang_kami">Tentang Kami</a></li>
                    <li><a href="/#kontak">Kontak</a></li>
                    <li><a href="/kategori_produk">Produk</a></li>
                    <li><a href="/artikel">Artikel</a></li>
                    @if ($active == 1)
                        <li><a href="/rekrut">Lowongan Pekerjaan</a></li>
                    @endif
                    <li><a href="/login">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container_isi">
        <section class="artikel" id="artikel">
            <h2>{{ $artikel->judul }}</h2>
            <img src="{{ \Storage::url($artikel->cover) }}" alt="{{ $artikel->judul }}" class="cover">
            <div class="konten">{!! $artikel->konten !!}</div>
        </section>

        <section class="detail" id="detail">
            <div class="penulis"><i class="fa-solid fa-feather"></i> Penulis : {{ $artikel->user->nama }}</div>
            <div class="tanggal"><i class="fa-solid fa-calendar-days"></i> Dibuat pada : {{ \Carbon\Carbon::parse($artikel->created_at)->format('d M Y') }}</div>
        </section>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Agung's Collection.
    </div>
</main>

<script>
    // Sticky Header dengan Efek Shrink
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
</script>
</body>
</html>
