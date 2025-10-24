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
            min-height: 550px;
            max-height: 550px;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            border: 20px solid rgb(250, 250, 250);
            border-bottom: 250px solid rgb(250, 250, 250);
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
            max-width: 350px;
            max-height: 500px;
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
            top: 300px;
            font-size: 15px;
            color: #800000;
            font-family: "Amaranth", sans-serif;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1; /* Limit text to 4 lines */
            -webkit-box-orient: vertical;
            line-height: 1.5em; /* Adjust to match font size */
            max-height: 2em; /* Adjust to match 4 lines */
        }

        .card .card-image .konten {
            font-weight: normal;
            position: relative;
            top: 300px;
            font-size: 13px;
            color: #1b1b1b;
            font-family: "Amaranth", sans-serif;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 4; /* Limit text to 4 lines */
            -webkit-box-orient: vertical;
            line-height: 1.5em; /* Adjust to match font size */
            max-height: 6em; /* Adjust to match 4 lines */
        }

        .card .card-image .date {
            font-weight: normal;
            position: relative;
            top: 265px;
            font-size: 14px;
            color: #800000;
            font-family: "Amaranth", sans-serif;
            text-align: left;
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

        .artikel h2 {
            text-align: center;
            font-family: 'Amaranth', sans-serif;
            font-weight: bold;
            color: #800000;
            width: 80%;
            margin: 60px auto 0 auto;
        }

        .artikel h4 {
            text-align: left;
            font-family: 'Amaranth', sans-serif;
            font-weight: bold;
            color: #800000;
            width: 80%;
            margin: 0 0 10px 0;
        }

        .artikel p {
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

        /* Custom Pagination Styles */
        .pagination {
            justify-content: center;
            display: flex;
            padding: 1rem 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 4px;
        }

        .pagination li a {
        display: block;
        padding: 8px 12px;
        text-decoration: none;
        border: 1px solid gray;
        color: black;
        margin: 0 4px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        }

        .pagination li a:hover {
        background-color: #ddd;
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

        body {
            background-image: url("{{ asset('images/bg.jpg') }}");
        }

        main {
            background-color: rgba(243, 244, 246, 0.95);
        }

        .container_product .card-list .empty{
            text-align: center;
            margin: 0 auto;
        }

        @media only screen and (max-width: 768px) {
            .navbar ul {
                text-align: center;
            }

            .hero {
                overflow: hidden; 
            }

            .hero .hero-text {
                text-align: center;
            }

            .hero .hero-text h1, .hero .hero-text p {
                width: 170%;
            }

            .hero img {
                height: 700px; 
                width: auto;
                display: block;
            }

            .artikel p {
                font-size: 12px;
            }

            .pagination {
                max-width: 100%;
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
        <!-- <img src="{{ asset('images/hero.png') }}" alt="Hero image"> -->
        <div class="hero-text">
            <h1>ARTIKEL TENTANG<br>AGUNG'S COLLECTION</h1>
        </div>
    </section>

    <section class="artikel" id="artikel">
        <h2>Artikel Terbaru</h2>
        <p>Jelajahi konten terbaru dan selalu terhubung dengan kami</p>
        <div class="container_product">
            <ul class="card-list">
            @forelse($artikels as $artikel)
                <li class="card">
                    <a href="{{ route('artikel.show', $artikel->slug) }}">
                        <div class="card-image" style="background-image: url({{ \Storage::url($artikel->cover) }});">
                            <h4>{{ $artikel->judul }}</h4>
                            <p class="konten">{{ strip_tags($artikel->konten) }}</p>
                            <p class="date"><i class="fa-regular fa-calendar-days"></i>&nbsp;{{ \Carbon\Carbon::parse($artikel->created_at)->format('d M Y') }}</p>
                        </div>
                    </a>
                </li>
            @empty
                <h4 class="empty">- No articles found. -</h4>
            @endforelse
            </ul>

            <!-- Pagination -->
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
            const totalPages = {{ $artikels->lastPage() }}; // Total pages from Laravel
            const currentPage = {{ $artikels->currentPage() }}; // Current page from Laravel
            const baseUrl = '{{ url()->current() }}'; // Base URL
    
            createPagination(totalPages, currentPage, baseUrl);
    
            // Re-create pagination on window resize
            window.addEventListener('resize', function() {
                createPagination(totalPages, currentPage, baseUrl);
            });
        });
    </script>  
</body>
</html>
