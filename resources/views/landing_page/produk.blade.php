<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agung's Collection</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Amaranth:ital,wght@0,400;0,700;1,400;1,700&family=Yatra+One&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=IM+Fell+English+SC&display=swap');

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif ;
            margin: 0;
            padding: 0;
            padding-top: 70px;
        }

        header {
            background-color: #252525;
            color: #fff;
            border-bottom: 1px solid #131313;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
            padding: 10px 0;
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

        .navbar li {
            transition: font-size 0.3s ease-in-out;
        }

        header.scrolled .navbar li {
            font-size: 14px;
        }

        .navbar a {
            color: #fff !important;
            text-decoration: none;
        }

        .navbar a:hover {
            color: #e44949 !important;
            text-decoration: none;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar li {
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
            position: absolute;
            top: 45%;
            left: 7%;
            transform: translateY(-50%);
            text-align: left;
            max-width: 50%;
        }

        .hero-text h1 {
            font-family: "Yatra One", system-ui;
            font-weight: 600;
            font-size: 45px;
            text-shadow: 2px 2px #2b2b2b;
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

        .card-list {
            display: block;
            margin: 1rem auto;
            padding: 0;
            font-size: 0;
            text-align: center;
            list-style: none;
        }

        .card {
            display: inline-block;
            width: 90%;
            max-width: 320px;
            max-height: 480px;
            margin: 1rem;
            font-size: 1rem;
            text-decoration: none;
            overflow: hidden;
            box-shadow: 0 0 3rem -1rem rgba(0,0,0,0.5);
            transition: transform 0.1s ease-in-out, box-shadow 0.1s;
            border-radius: 7px;
        }

        .card .card-image h4 {
            font-weight: 900;
            position: relative;
            top: 280px;
            font-size: 16px;
            color: rgba(0,0,0,.9);
            font-family: "Amaranth", sans-serif;
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

        .sub_title {
            text-align: center;
            font-size: 40px;
            font-family: 'IM Fell English SC', serif;
            font-weight: 600;
            color: rgb(50, 50, 50);
            margin-top: 100px;
            margin-bottom: 0;
        }

        .title p {
            text-align: center;
            font-size: 15px;
            line-height: 25px;
            font-family: Arial, Helvetica, sans-serif;
            color: rgb(50, 50, 50);
            margin: 25px 15% 25px 15%;
        }

        .produk h2, h4 {
            text-align: center;
            font-family: 'Amaranth', sans-serif;
            font-weight: bold;
            color: #800000;
            width: 80%;
            margin: 60px auto 0 auto;
        }

        .produk p {
            text-align: center;
            font-family: 'Amaranth', sans-serif;
            font-weight: bold;
            color: rgb(37, 37, 37);
            width: 100%;
            margin: 0 auto 50px auto;
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
            padding: 20px;
            margin-bottom: 0;
        }

        /* disable page background image to avoid unexpected bg.jpg showing */
        body {
            background-image: none;
        }

        main {
            background-color: rgba(243, 244, 246, 0.95);
        }

        /* Custom Pagination Styles */
        .pagination {
            justify-content: center;
            display: flex;
            padding: 1rem 0;
            margin: 0;
        }

        .pagination li {
            margin: 0;
        }

        .pagination a {
            color: #800000; /* Warna teks */
            border: 1px solid #800000; /* Warna border */
            border-radius: 0;
        }

        .pagination a:hover {
            background-color: #800000; /* Warna latar belakang saat hover */
            color: #fff; /* Warna teks saat hover */
        }

        .pagination .active .page-link {
            background-color: #800000; /* Warna latar belakang halaman aktif */
            color: #fff; /* Warna teks halaman aktif */
            border: 1px solid #800000; /* Warna border halaman aktif */
        }

        .pagination .disabled .page-link {
            color: #696969; /* Warna teks halaman dinonaktifkan */
            border: 1px solid #696969; /* Warna border halaman dinonaktifkan */
        }

        .pagination .ellipsis {
            cursor: default;
        }

        .produk p a {
            color: #800000;
        }

        @media only screen and (max-width: 768px) {
            .navbar ul {
                text-align: center;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .hero {
                overflow: hidden;
            }

            .hero .hero-text {
                /* switch to stacked layout on mobile */
                position: relative;
                top: auto;
                left: auto;
                transform: none;
                text-align: center;
                max-width: 100%;
                padding: 2rem 1rem;
                height: 60vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .hero .hero-text h1 {
                width: 100%;
                font-size: 28px;
                line-height: 1.05;
                margin: 0.2rem 0;
            }

            .hero .hero-text p {
                width: 100%;
                font-size: 14px;
                margin: 0.4rem 0 0 0;
            }

            .hero img {
                height: auto;
                width: 100%;
                display: block;
            }

            .produk p {
                font-size: 12px;
            }

            .pagination {
                max-width: 100%;
            }
        }


        /* WhatsApp Floating Button */
        .pesan-sekarang-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            z-index: 9999;
            transition: all 0.3s ease;
            text-decoration: none;
            animation: pulse 2s infinite;
        }

        .pesan-sekarang-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(37, 211, 102, 0.6);
            text-decoration: none;
        }

        .pesan-sekarang-btn i {
            font-size: 35px;
            color: white;
        }

        /* Tooltip */
        .pesan-sekarang-btn::before {
            content: "Chat dengan Kami";
            position: absolute;
            right: 75px;
            background: rgba(0, 0, 0, 0.85);
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Amaranth', sans-serif;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transform: translateX(10px);
            transition: all 0.3s ease;
            pointer-events: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        /* Arrow tooltip */
        .pesan-sekarang-btn::after {
            content: "";
            position: absolute;
            right: 65px;
            border: 6px solid transparent;
            border-left-color: rgba(0, 0, 0, 0.85);
            opacity: 0;
            visibility: hidden;
            transform: translateX(10px);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .pesan-sekarang-btn:hover::before,
        .pesan-sekarang-btn:hover::after {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }

        /* Pulse Animation */
        @keyframes pulse {
            0% {
                box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            }
            50% {
                box-shadow: 0 4px 25px rgba(37, 211, 102, 0.6), 0 0 0 10px rgba(37, 211, 102, 0.1);
            }
            100% {
                box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            }
        }

        @media only screen and (max-width: 768px) {
            .pesan-sekarang-btn {
                bottom: 20px;
                right: 20px;
                width: 60px;
                height: 60px;
            }

            .pesan-sekarang-btn i {
                font-size: 32px;
            }

            /* Hide tooltip on mobile */
            .pesan-sekarang-btn::before,
            .pesan-sekarang-btn::after {
                display: none;
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
    </style>
</head>
<body>
    <main>
    <header>
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
                        <li class="nav-item"><a class="nav-link" href="/#beranda">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="/#tentang_kami">Tentang Kami</a></li>
                        <li class="nav-item"><a class="nav-link" href="/#kontak">Kontak</a></li>
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
        <img src="{{ asset('images/hero.png') }}" alt="Hero image">
        <div class="hero-text">
            <h1>PRODUK-PRODUK DI<br>AGUNG'S COLLECTION</h1>
        </div>
    </section>

    <section class="produk" id="produk">
        <h2>{{ $kategori->nama }}</h2>
        <p>{{ $kategori->keterangan }}</p>
        <div class="container_product">
            <ul class="card-list">
            @forelse($produks as $produk)
                <li class="card" data-toggle="modal" data-target="#productModal{{ $produk->id }}">
                    <div class="card-image"
                        style="background-image: url({{ \Storage::url($produk->foto_sampul) }});">
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
                                            if($produk->foto_sampul) $media[] = ['type' => 'image', 'src' => \Storage::url($produk->foto_sampul)];
                                            if($produk->foto_lain_1) $media[] = ['type' => 'image', 'src' => \Storage::url($produk->foto_lain_1)];
                                            if($produk->foto_lain_2) $media[] = ['type' => 'image', 'src' => \Storage::url($produk->foto_lain_2)];
                                            if($produk->foto_lain_3) $media[] = ['type' => 'image', 'src' => \Storage::url($produk->foto_lain_3)];
                                            if($produk->video) $media[] = ['type' => 'video', 'src' => \Storage::url($produk->video)];
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
                <h4>- No products found. -</h4>
            @endforelse
            </ul>

            <nav>
                <ul class="pagination">
                    <!-- Pagination links will be dynamically inserted here -->
                </ul>
            </nav>
        </div>
    </section>

    <div class="footer">
        &copy; {{ date('Y') }} Agung's Collection.
    </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function createPagination(totalPages, currentPage, baseUrl) {
            const pagination = document.querySelector('.pagination');
            pagination.innerHTML = ''; // Clear existing pagination

            if (totalPages <= 1) {
                return;
            }

            const maxVisible = 5;
            let start = 1;
            let end = totalPages;

            if (window.innerWidth <= 768) { // Detect mobile screen size
                // Previous button
                if (currentPage > 1) {
                    pagination.innerHTML += `<li class="page-item"><a class="page-link" href="${baseUrl}?page=${currentPage - 1}">Previous</a></li>`;
                } else {
                    pagination.innerHTML += '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
                }

                // Next button
                if (currentPage < totalPages) {
                    pagination.innerHTML += `<li class="page-item"><a class="page-link" href="${baseUrl}?page=${currentPage + 1}">Next</a></li>`;
                } else {
                    pagination.innerHTML += '<li class="page-item disabled"><span class="page-link">Next</span></li>';
                }
            } else {
                if (totalPages > maxVisible) {
                    if (currentPage <= Math.floor(maxVisible / 2)) {
                        end = maxVisible;
                    } else if (currentPage >= totalPages - Math.floor(maxVisible / 2)) {
                        start = totalPages - maxVisible + 1;
                    } else {
                        start = currentPage - Math.floor(maxVisible / 2);
                        end = currentPage + Math.floor(maxVisible / 2);
                    }
                }

                // First button
                if (currentPage > 1) {
                    pagination.innerHTML += `<li class="page-item"><a class="page-link" href="${baseUrl}?page=1">First</a></li>`;
                } else {
                    pagination.innerHTML += '<li class="page-item disabled"><span class="page-link">First</span></li>';
                }

                // Previous button
                if (currentPage > 1) {
                    pagination.innerHTML += `<li class="page-item"><a class="page-link" href="${baseUrl}?page=${currentPage - 1}">Previous</a></li>`;
                } else {
                    pagination.innerHTML += '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
                }

                // Start ellipsis
                if (start > 1) {
                    pagination.innerHTML += '<li class="page-item disabled"><span class="page-link ellipsis">...</span></li>';
                }

                // Page numbers
                for (let i = start; i <= end; i++) {
                    if (i === currentPage) {
                        pagination.innerHTML += `<li class="page-item active"><a class="page-link" href="#">${i}</a></li>`;
                    } else {
                        pagination.innerHTML += `<li class="page-item"><a class="page-link" href="${baseUrl}?page=${i}">${i}</a></li>`;
                    }
                }

                // End ellipsis
                if (end < totalPages) {
                    pagination.innerHTML += '<li class="page-item disabled"><span class="page-link ellipsis">...</span></li>';
                }

                // Next button
                if (currentPage < totalPages) {
                    pagination.innerHTML += `<li class="page-item"><a class="page-link" href="${baseUrl}?page=${currentPage + 1}">Next</a></li>`;
                } else {
                    pagination.innerHTML += '<li class="page-item disabled"><span class="page-link">Next</span></li>';
                }

                // Last button
                if (currentPage < totalPages) {
                    pagination.innerHTML += `<li class="page-item"><a class="page-link" href="${baseUrl}?page=${totalPages}">Last</a></li>`;
                } else {
                    pagination.innerHTML += '<li class="page-item disabled"><span class="page-link">Last</span></li>';
                }
            }
        }

        // Example usage
        document.addEventListener('DOMContentLoaded', function() {
            const totalPages = {{ $produks->lastPage() }}; // Total pages from Laravel
            const currentPage = {{ $produks->currentPage() }}; // Current page from Laravel
            const baseUrl = '{{ url()->current() }}'; // Base URL

            createPagination(totalPages, currentPage, baseUrl);

            // Re-create pagination on window resize
            window.addEventListener('resize', function() {
                createPagination(totalPages, currentPage, baseUrl);
            });
        });

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

    <a class="pesan-sekarang-btn" href="https://wa.me/6281235621208?text=Halo,%20saya%20ingin%20membeli%20produk%20secara%20eceran%20di%20Agung's%20Collection.%0ANama%3A%20%5BNama%20Anda%5D%0AProduk%3A%20%5BProduk%20yang%20dibeli%5D%0AJumlah%3A%20%5BJumlah%20Produk%5D%0AAlamat%3A%20%5BAlamat%20Pengiriman%5D
    " target="_blank" title="Chat dengan Kami">
        <i class="fab fa-whatsapp"></i>
    </a>
</body>
</html>
