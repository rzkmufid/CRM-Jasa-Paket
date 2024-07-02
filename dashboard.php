    <style>
        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-top: 20px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .welcome-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 15vh;
        }

        .welcome-text {
            flex: 1;
        }

        .welcome-image {
            flex: 1;
            text-align: center;
        }

        .welcome-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            /* box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); */
        }

        .welcome-text h1,
        .card-body h5 {
            color: #4584FF;
            font-weight: 600;
            font-family: 'Outfit-Bold';
        }

        .welcome-text p {
            font-size: 18px;
        }

        .card {
            height: 220px;
            justify-content: center;
        }
    </style>
    <div class="welcome-section">
        <div class="welcome-text">
            <h1 class="mb-4">Selamat Datang di Layanan Pengiriman Kami</h1>
            <p class="lead">Menyediakan solusi pengiriman barang yang cepat dan andal.</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cek Ongkir</h5>
                            <p class="card-text">Cari tahu tarif pengiriman berdasarkan kota asal dan tujuan Anda.</p>
                            <a href="index.php?page=cek_ongkir" class="btn btn-primary">Cek Ongkir</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cek Resi</h5>
                            <p class="card-text">Lacak status pengiriman barang Anda dengan mudah.</p>
                            <a href="index.php?page=cek_resi" class="btn btn-primary">Cek Resi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="welcome-image">
            <img src="img/oto.png" alt="Pengiriman Barang">
        </div>
    </div>