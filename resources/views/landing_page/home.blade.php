<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agung's Collection</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Amaranth:ital,wght@0,400;0,700;1,400;1,700&family=Calistoga&family=DM+Serif+Display:ital@0;1&family=Yatra+One&display=swap');

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif ;
            margin: 0;
            padding: 0;
        }

        header {
            color: #fff;
            background: rgba(0,0,0,0.35); /* warna gelap semi-transparan */
            backdrop-filter: blur(1px);   /* efek blur */
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        nav a {
            color: #fff !important;
            text-decoration: none;
        }

        nav a:hover {
            color: #e44949 !important;
            text-decoration: none;
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

        .hero {
            position: relative;
            color: #fff;
            text-align: center;
        }

        .hero img {
            width: 100%;
            height: auto;
            filter: drop-shadow(0 0 10px #222);
        }

        .hero-text {
            position: relative;
            background-image: url("{{ asset('images/section_welcome.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-flow: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100vh;
            z-index: 1;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 4.19);
        }

        .hero-text::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.45); /* Ubah opacity sesuai kebutuhan */
            z-index: 2;
            pointer-events: none;
        }

        .hero-text > * {
            position: relative;
            z-index: 3;
        }

        .hero-text h1 {
            font-family: "Yatra One", system-ui;
            font-weight: 600;
            font-size: 45px;
            text-shadow: 2px 2px #2b2b2b;
        }

        .hero-text p {
            font-family: 'Amaranth', sans-serif;
            font-size: 17px;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Ensure the about section container stacks its children vertically
           so the heading appears above the boxes instead of beside them */
        .about .container {
            display: block;
        }

        .about {
            /* adjust top/bottom padding to position the title similar to the reference image */
            padding: 60px 0 40px 0;
        }

        .about .col-md-6 img {
            width: 100%;
            height: auto;
            border: 3px solid #242424;
            border-radius: 5px;
        }

        .about .container h2 {
            font-family: 'Amaranth', sans-serif;
            font-weight: bold;
            color: #800000;
            margin-top: 100px;
        }

        .about .container p {
            font-family: 'Amaranth', sans-serif;
            margin-bottom: 100px;
            line-height: 30px;
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
        }

        .footer .container p {
            text-align: center;
            width: 100%;
            margin: 0
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

        .kontak {
            padding: 60px 0;
            background-color: #252525;
            margin-bottom: 1px;
        }

        .kontak h2 {
            text-align: center;
            font-family: 'Amaranth', sans-serif;
            font-weight: bold;
            color: #fff;
            width: 80%;
            margin: 0 auto 40px auto;
        }

        .kontak .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .kontak ul {
            list-style: none;
            padding: 0;
            font-family: 'Amaranth', sans-serif;
            color: #fff;
        }

        .kontak ul li {
            margin-bottom: 10px;
        }

        .kontak ul li i {
            margin-right: 10px;
            color: #e44949;
        }

        .mapouter {
            position: relative;
            text-align: right;
            height: 350px;
        }

        .gmap_canvas {
            overflow: hidden;
            background: none;
            height: 350px;
            border-radius: 7px;
        }

        .gmap_iframe {
            height: 350px;
        }

        body {
            background-image: url("{{ asset('images/bg.jpg') }}");
        }

        main {
            background-color: rgba(243, 244, 246, 0.95);
        }

        .kontak label, .kontak p {
            color: white;
            font-family: 'Amaranth', sans-serif;
        }

        .kontak .form {
            top: -6px;
        }

        .kontak button {
            background-color: #800000;
            border: 1px solid white;
            font-family: 'Amaranth', sans-serif;
        }

        .kontak button:hover {
            background-color: #4d0000;
            border: 1px solid white;
            font-family: 'Amaranth', sans-serif;
        }

        @media only screen and (max-width: 768px) {
            /* Stack nav items vertically on small screens */
            nav ul {
                text-align: center;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            /* Make hero behave on small screens: reduce height, add padding and prevent overflow */
            .hero {
                overflow: hidden;
            }

            .hero .hero-text {
                text-align: center;
                height: 60vh; /* reduce from 100vh for better fit */
                padding: 2rem 1rem;
                background-position: center;
                justify-content: center;
            }

            /* Ensure heading and paragraph fit the viewport */
            .hero .hero-text h1 {
                width: 100%;
                font-size: 28px;
                line-height: 1.05;
                margin: 0.2rem 0;
                text-wrap: balance;
            }

            .hero .hero-text p {
                width: 100%;
                font-size: 14px;
                margin: 0.4rem 0 0 0;
            }

            /* Make the hero background image responsive */
            .hero img {
                height: auto;
                width: 100%;
                display: block;
            }

            /* About section: simpler spacing for stacked layout */
            .about .row .col-md-6 {
                text-align: center !important;
                margin-bottom: 20px;
            }

            .about .row .image_1 h2,
            .about .row .image_2 h2 {
                margin-top: 20px;
            }

            .about .row .image_1 p,
            .about .row .image_2 p {
                margin-bottom: 0;
            }

            /* reset absolute positioning on small screens to avoid overflow */
            .about .row .image_2 img {
                position: static;
                bottom: auto;
                left: auto;
                display: block;
                margin: 0 auto;
                max-width: 100%;
            }

            .kontak button {
                margin-bottom: 30px;
            }

            .kontak .container {
                justify-content: center;
                padding: 0 1rem;
            }

            .p_rekomendasi_produk {
                font-size: 12px;
            }
        }

        .kontak .alert_success {
            width: 90%;
            margin: 0 auto;
            text-align: center;
        }

        .title_rekomendasi_produk, .no_product_found {
            text-align: center;
            font-family: 'Amaranth', sans-serif;
            font-weight: bold;
            color: #800000;
            width: 80%;
            margin: 100px auto 0 auto;
        }

        /* Title for the 'Mengapa Harus Kami?' section - match font + color of Rekomendasi Produk */
        .mengapa-title {
            text-align: center;
            font-family: 'Amaranth', sans-serif;
            font-weight: bold;
            color: #800000;
            font-size: 32px;
            /* tuned top and bottom spacing to match the reference */
            margin: 20px auto 30px auto !important;
            width: 80%;
            line-height: 1.1;
        }

        /* Ensure the mengapa title uses these margins inside .about */
        .about .container h2.mengapa-title {
            margin-top: 20px !important;
            margin-bottom: 30px !important;
        }

        .modal-product-image {
            width: 90%;
            height: 550px;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            border-bottom: 1px solid #ddd;
            margin-bottom: 1rem;
            background-color: #585858;
            margin: 0 auto;
            border-radius: 7px;
        }

        .modal-body p {
            font-size: 15px;
            font-weight: normal;
            font-family: 'Amaranth', sans-serif;
            text-align: center;
            padding: 20px;
            margin-bottom: 0;
        }

        .card-image {
            display: block;
            min-height: 400px;
            max-height: 400px;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            border: 15px solid rgb(250, 250, 250);
            border-bottom: 65px solid rgb(250, 250, 250);
            background-color: #585858;
        }

        /* Card container and fancy card styles (adapted from provided mixin) */
        :root{
            --bg: 25% 0.0075 70;
            --pink: 77.75% 0.1003 350.51;
            --gold: 84.16% 0.1169 71.19;
            --mint: 84.12% 0.1334 165.28;
            --mobile--w: 360px;
            --mobile--h: 540px;
            --outline-w: 9px;
            --preview-bg: #fff;
        }

        .card-list {
            /* use flex container to center previews */
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            align-items: center;
            margin: 1rem auto;
            padding: 0;
            list-style: none;
        }

        .card {
            --bg-pos-y--start: 0;
            --bg-pos-y--end: 0;
            --bg-pos-y: var(--bg-pos-y--start);
            --delay: 0s;
            --duration: 6s;
            --img: url('{{ asset('images/default-product.jpg') }}');
            --shadow-blur: 24px;
            --shadow-color: rgba(0,0,0,0.12);

            background-clip: padding-box;
            background-image: var(--img);
            background-position-y: var(--bg-pos-y);
            background-repeat: no-repeat;
            background-size: cover;

            border: var(--outline-w) solid transparent;
            border-radius: 6px;
            box-shadow: 0 0 var(--shadow-blur) 0 var(--shadow-color);

            transition: border 0.15s, box-shadow 0.15s, filter 0.6s, outline-offset 0.6s, opacity 0.3s, transform 0.3s, z-index 0.15s;

            filter: grayscale(100%) sepia(5%);
            mix-blend-mode: multiply;
            opacity: 0.69;

            transform: scale(0.85) rotate(var(--rotation, -4deg));

            outline: var(--outline-w) solid var(--preview-bg);
            outline-offset: var(--outline-w);

            min-height: var(--mobile--h);
            min-width: var(--mobile--w);
            width: 100%;
            max-width: 320px;
            height: 100%;

            position: relative;
            overflow: hidden;

            animation-name: bg-scroll;
            animation-delay: var(--delay);
            animation-duration: var(--duration);
            animation-fill-mode: forwards;
        }

        .card:focus-within,
        .card:hover{
            --shadow-blur: 200px;
            --shadow-color: rgba(255,200,0,0.15);
            --border-color: var(--shadow-color);
            background-color: white;
            mix-blend-mode: initial;
            filter: none;
            opacity: 1;
            outline-offset: calc(var(--outline-w) / 2);
            transform: scale(1) rotate(0deg);
            z-index: 6;
        }

        .card:focus-within{ z-index: 7; }

        /* Slight per-card variations similar to provided example */
        .card:nth-of-type(2){ --bg-pos-y--end: calc(var(--mobile--h) * -1.025); --rotation: 3deg; }
        .card:nth-of-type(3){ --bg-pos-y--end: calc(var(--mobile--h) * -2.25); --duration: 6.5s; --rotation: -1deg; }
        .card:nth-of-type(4){ --bg-pos-y--end: calc(var(--mobile--h) * -3.75); --duration: 6.75s; --rotation: -5deg; }
        .card:nth-of-type(5){ --bg-pos-y--end: calc(var(--mobile--h) * -4.82); --duration: 7s; --rotation: -2deg; }
        .card:nth-of-type(6){ --bg-pos-y--end: calc(var(--mobile--h) * -5.85); --duration: 7.25s; --rotation: 2deg; }
        .card:nth-of-type(7){ --bg-pos-y--end: calc(var(--mobile--h) * -7.21); --duration: 7.5s; --rotation: 4deg; }

        /* If the HTML uses inner .card-image for preview, keep it but make it occupy the visible area */
        .card .card-image {
            display: block;
            width: 100%;
            height: 320px;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            border-bottom: 20px solid #fff;
            background-color: #585858;
            border-radius: 6px 6px 0 0;
        }

        .card .card-image h4 {
            font-weight: 900;
            position: relative;
            top: 0;
            font-size: 16px;
            color: rgba(0,0,0,.9);
            font-family: "Amaranth", sans-serif;
            padding: 0.75rem 1rem;
            text-align: center;
            background: #fff;
            margin: 0;
        }

        @keyframes bg-scroll { to { background-position-y: var(--bg-pos-y--end); } }

        /* subtle glow that follows cursor when hovering a card */
        .card::before{
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            border-radius: inherit;
            mix-blend-mode: screen;
            opacity: 0;
            transition: opacity 260ms ease, transform 260ms ease;
            /* default position center */
            --mouse-x: 50%;
            --mouse-y: 50%;
            /* two-layer approach: subtle moving center (top) + fixed outer ring (below) */
            /* the second radial-gradient creates an orange ring near the card edge */
            background:
                radial-gradient(circle at var(--mouse-x) var(--mouse-y),
                    rgba(255,200,80,0.00) 0%,
                    rgba(255,200,80,0.00) 10%,
                    rgba(255,180,60,0.12) 26%,
                    rgba(255,150,40,0.08) 34%,
                    transparent 48%
                ),
                radial-gradient(circle at 50% 50%,
                    rgba(255,200,80,0.00) 0%,
                    rgba(255,200,80,0.00) 64%,
                    rgba(255,180,60,0.28) 72%,
                    rgba(255,150,40,0.22) 78%,
                    rgba(255,120,30,0.16) 86%,
                    transparent 94%
                );
            filter: blur(18px);
        }

        .card:hover::before,
        .card:focus-within::before{
            opacity: 1;
        }

        @media only screen and (max-width: 450px) {
            .card {
                width: 70%;
            }
        }

        .card:hover {
            transform: translateY(-0.5rem) scale(1.0125);
            box-shadow: 0 0.5em 3rem -1rem rgba(0,0,0,0.5);
        }

        .card-description {
            display: block;
            padding: 1em 0.5em;
            color: #515151;
            text-decoration: none;
        }

        .card-description > h2 {
            margin: 0 0 0.5em;
        }

        .card-description > p {
            margin: 0;
        }

        .p_rekomendasi_produk{
            text-align: center;
            font-family: 'Amaranth', sans-serif;
            font-weight: bold;
            color: rgb(37, 37, 37);
            width: 100%;
            margin: 0 auto 50px auto;
        }


        .pesan-sekarang-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            color: white;
            z-index: 9999; /* Pastikan tombol ini berada di atas konten lainnya */
        }

        .pesan-sekarang-btn img {
            width: 250px;
        }

        @media only screen and (max-width: 768px) {
            .pesan-sekarang-btn {
                bottom: 15px;
                right: 15px;
            }

            .pesan-sekarang-btn img {
                width: 200px;
            }
        }

        .carousel-control-prev,
        .carousel-control-next {
            top: 50%;
            transform: translateY(-50%);
            height: auto;
            width: auto;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-size: 30px 30px; /* perkecil ikon */
        }

        .carousel-control-prev {
            left: 10px; /* jarak dari sisi kiri */
        }

        .carousel-control-next {
            right: 10px; /* jarak dari sisi kanan */
        }

        /* === Agar tinggi kedua box sama === */
        .equal-height {
        display: flex;
        flex-wrap: wrap;
        }

        .equal-height .col-md-6 {
        display: flex;
        }

        .equal-height > [class*='col-'] {
        display: flex;
        }

        .equal-height .box {
        flex: 1;
        display: flex;
        flex-direction: column;
        }

        /* === Style box === */
    .box {
    --borderradius: 14px;
    background: #fff;
    border: 1px solid #222;
    border-radius: var(--borderradius);
    /* Further reduced padding to tighten vertical spacing */
    padding: 0.35rem 0.7rem;
    text-align: center;
    transition: all 0.2s ease-in-out;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* biar isi sejajar */
    height: 100%; /* biar semua kolom sama tinggi */
    overflow: hidden; /* prevents inner scrollbars from pseudo-elements or content */
    }

        .box:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .box::before,
        .box::after {
        border-radius: var(--borderradius, 14px);
        background-image: linear-gradient(
            45deg,
            #fff 33.33%,
            rgba(0, 0, 0, 0.95) 33.33%,
            rgba(0, 0, 0, 0.95) 50%,
            #fff 50%,
            #fff 83.33%,
            rgba(0, 0, 0, 0.95) 83.33%,
            rgba(0, 0, 0, 0.95) 100%
        );
        content: "";
        display: block;
        position: absolute;
        z-index: -2;
        /* keep pseudo-elements inset inside the .box to avoid overflow */
        top: 0.75rem;
        left: 0.75rem;
        right: 0.75rem;
        bottom: 0.75rem;
        box-sizing: border-box;
        background-size: var(--bgsize, 0.28rem) var(--bgsize, 0.28rem);
        }

    .box::before {
    /* inner white background that sits flush with the box */
    inset: 0;
    box-sizing: border-box;
    background: white;
    z-index: -1;
    }

        /* === Gambar === */
    .box img {
    width: 100%;
    max-height: 230px; /* 🔹 kurangi tinggi gambar */
    object-fit: cover;
    border-radius: 12px;
    /* reduced bottom margin to bring title closer */
    margin-bottom: 0.15rem;
    }

        /* === Judul === */
    .box h2 {
    font-family: 'Amaranth', sans-serif;
    color: #800000;
    font-size: 20px;
    font-weight: bold;
    /* tighten top and bottom margins for heading */
    margin: 0.05rem 0 0.2rem;
    }


        /* === Paragraf === */
    .box p {
    font-size: 15px;
    /* even tighter line-height and smaller bottom margin */
    line-height: 1.3;
    text-align: justify;
    margin: 0 0 0.15rem 0;
    padding: 0;
    }

    /* === FIX agar tampilan tidak bisa digeser (horizontal scroll) === */
html, body {
    overflow-x: hidden !important; /* cegah geser horizontal */
    width: 100%;
    max-width: 100%;
}

/* pastikan semua elemen tidak keluar dari viewport */
* {
    box-sizing: border-box;
}

/* kadang ada container bootstrap yang melebihi layar — ini mencegahnya */
.container,
.row,
.col-md-6,
.card-list,
.hero,
.about,
.kontak {
    overflow-x: hidden;
}

/* kalau masih bisa geser di mobile, tambahkan juga ini */
@media (max-width: 768px) {
    body {
        position: relative;
        overflow-x: hidden !important;
    }
}


    </style>
</head>
<body>
    <main>
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tentang_kami">Tentang Kami</a></li>
                        <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                        <li class="nav-item"><a class="nav-link" href="/kategori_produk">Produk</a></li>
                        <li class="nav-item"><a class="nav-link" href="/artikel">Artikel</a></li>
                        @if ($active == 1)
                            <li class="nav-item"><a class="nav-link" href="/rekrut">Lowongan Pekerjaan</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="hero" id="beranda"> 
        <div class="hero-text">
            <h1>SELAMAT DATANG DI<br>AGUNG'S COLLECTION</h1>
            <p>Tempat yang tepat untuk menghasilkan pakaian dan tekstil terbaik.</p>
        </div>
    </section>

    <section class="about" id="tentang_kami">
<div class="container">
        <h2 class="mengapa-title">Mengapa Harus Kami?</h2>
        <div class="row equal-height">
            <!-- Bagian Kualitas Tetap Terjaga -->
            <div class="col-md-6">
                <div class="box image_1">
                    <img src="{{ asset('images/tentang_kami_1.jpg') }}" alt="About Image 1">
                    <h2>Kualitas Produk Terjamin Terjaga</h2>
                    <p>
                        Walau memiliki banyak pekerja dan mampu menyelesaikan pekerjaan dengan cepat, 
                        Agung's Collection yang memiliki para pekerja yang terampil mampu menangani 
                        pesanan dalam jumlah besar dengan tetap menjaga kualitas tinggi pada setiap 
                        produk yang dihasilkan. Jadi dengan proses pengerjaan yang cepat kami tidak akan 
                        pernah mengorbankan kualitas karena kualitas tetaplah yang utama bagi kami.
                    </p>
                </div>
            </div>

            <!-- Bagian Pekerja yang Banyak -->
            <div class="col-md-6">
                <div class="box image_2">
                    <img src="{{ asset('images/tentang_kami_2.jpg') }}" alt="About Image 2">
                    <h2>Tenaga kerja Yang Berkompeten</h2>
                    <p>
                        Agung's Collection dikenal sebagai salah satu industri tekstil dan garmen yang 
                        memiliki jumlah pekerja yang banyak dan kompeten. Jumlah pekerja yang banyak 
                        memungkinkan kami untuk fleksibel dan cepat dalam merespons permintaan pesanan. 
                        Kami dapat menangani berbagai proyek, baik skala kecil maupun besar, dengan efisiensi. 
                        Keberhasilan kami adalah hasil dari kerja keras dan dedikasi para pekerja kami yang ahli 
                        dalam bidangnya masing-masing.
                    </p>
                </div>
            </div>
        </div>
    </div>


        <h2 class="title_rekomendasi_produk">Rekomendasi Produk</h2>
        <p class="p_rekomendasi_produk">Berikut merupakan 3 produk terlaris kami</p>
        <div class="container_product">
            <ul class="card-list">
            @forelse($produk_terlaris as $produk)
                @php
                    $backgroundImage = $produk->foto_sampul ? \Storage::url($produk->foto_sampul) : asset('images/default-product.jpg');
                @endphp
                <li class="card" data-toggle="modal" data-target="#productModal{{ $produk->id }}">
                    <div class="card-image" style="background-image: url('{{ $backgroundImage }}');">
                        <h4>{{ $produk->nama_produk }}</h4>
                    </div>
                </li>

                <!-- Modal for each product -->
                <div class="modal fade" id="productModal{{ $produk->id }}" tabindex="-1" role="dialog" aria-labelledby="productModalLabel{{ $produk->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel{{ $produk->id }}">{{ $produk->nama_produk }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <!-- Bootstrap Carousel -->
                                <div id="carousel{{ $produk->id }}" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        @php
                                            $media = [];
                                            if($produk->foto_sampul ?? null) $media[] = ['type' => 'image', 'src' => \Storage::url($produk->foto_sampul)];
                                            if($produk->foto_lain_1 ?? null) $media[] = ['type' => 'image', 'src' => \Storage::url($produk->foto_lain_1)];
                                            if($produk->foto_lain_2 ?? null) $media[] = ['type' => 'image', 'src' => \Storage::url($produk->foto_lain_2)];
                                            if($produk->foto_lain_3 ?? null) $media[] = ['type' => 'image', 'src' => \Storage::url($produk->foto_lain_3)];
                                            if($produk->video ?? null) $media[] = ['type' => 'video', 'src' => \Storage::url($produk->video)];
                                        @endphp

                                        @foreach($media as $index => $item)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                @if($item['type'] === 'image')
                                                    <img src="{{ $item['src'] }}" class="d-block w-100" alt="Media Produk">
                                                @elseif($item['type'] === 'video')
                                                    <video class="d-block w-100" controls>
                                                        <source src="{{ $item['src'] }}" type="video/mp4">
                                                        Browser Anda tidak mendukung video tag.
                                                    </video>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Controls -->
                                    @if(count($media) > 1)
                                        <a class="carousel-control-prev" href="#carousel{{ $produk->id }}" role="button" data-slide="prev">
                                            <span style="filter: invert(50%) grayscale(100%);" class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carousel{{ $produk->id }}" role="button" data-slide="next">
                                            <span style="filter: invert(50%) grayscale(100%);" class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    @endif
                                </div>

                                <p class="mt-3">{{ $produk->deskripsi_produk }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h4 class="no_product_found">- No products found. -</h4>
            @endforelse
            </ul>

            <nav>
                <ul class="pagination">
                    <!-- Pagination links will be dynamically inserted here -->
                </ul>
            </nav>
        </div>

    </section>

    <section class="kontak" id="kontak">
        <h2>Hubungi Kami</h2>
        <div class="alert_success">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="container">
            <div class="row" style="width: 100%">
                <div class="col-md-6 form">
                    <p>Berminat kemitraan dengan Agung's Collection?, isi form dibawah dan akan kami hubungi segera.</p>
                    <form action="{{ route('calon_mitra.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_wa">Nomor WA</label>
                            <input type="text" class="form-control" id="nomor_wa" name="nomor_wa" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Alamat: Ds. Sraturejo RT 02 RW 06, Kec. Baureno, Kab. Bojonegoro</li>
                        <li><i class="fas fa-phone"></i> +62 815-1234-5678</li>
                        <li>
                            <a href="https://www.instagram.com/cv.ekajayatekstil?igsh=MTFlb3VpZDl3ZTA1bw%3D%3D" target="_blank" style="text-decoration: none; color: inherit;">
                                <i class="fab fa-instagram"></i> @cv.ekajayatekstil
                            </a>
                        </li>
                        <li>
                            <a href="https://www.tiktok.com/@cv.ekajayatekstil?_t=ZS-8yLmDbtHu6h&_r=1" target="_blank" style="text-decoration: none; color: inherit;">
                                <i class="fab fa-tiktok"></i> @cv.ekajayatekstil
                            </a>
                        </li>
                    </ul>
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe width="100%" height="330" id="gmap_canvas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.2952514471554!2d112.0899525!3d-7.1356027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e778f2c6627d00d%3A0x7afa90f3e1737a9c!2sV37R%2BF4W%2C%20Grenjeng%2C%20Sraturejo%2C%20Kec.%20Baureno%2C%20Kabupaten%20Bojonegoro%2C%20Jawa%20Timur!5e0!3m2!1sen!2sid!4v1689072093765!5m2!1sen!2sid" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Agung's Collection. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Glow follow cursor for .card
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mousemove', function(e){
                const rect = card.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                card.style.setProperty('--mouse-x', x + '%');
                card.style.setProperty('--mouse-y', y + '%');
            });
            card.addEventListener('mouseleave', function(){
                // optional: reset to center slowly
                card.style.setProperty('--mouse-x', '50%');
                card.style.setProperty('--mouse-y', '50%');
            });
        });
    </script>

    <a class="pesan-sekarang-btn" href="https://wa.me/6281235621208?text=Halo,%20saya%20ingin%20membeli%20produk%20secara%20eceran%20di%20Agung's%20Collection.%0ANama%3A%20%5BNama%20Anda%5D%0AProduk%3A%20%5BProduk%20yang%20dibeli%5D%0AJumlah%3A%20%5BJumlah%20Produk%5D%0AAlamat%3A%20%5BAlamat%20Pengiriman%5D
    " target="_blank">
        <img src="{{ asset('images/pesan_sekarang.png') }}" alt="Pesan Sekarang" class="pesan_sekarang">
    </a>
</main>
</body>
</html>
