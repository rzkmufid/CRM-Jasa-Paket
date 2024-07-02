<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Kiriman </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            if ($result1->num_rows > 0) {
                                // Mengambil hasil query
                                $row = $result1->fetch_assoc();
                                echo $row["total_rows"] . " ";
                            } else {
                                echo "0 ";
                            }
                            ?>
                            Kiriman
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jumlah Driver</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            if ($result3->num_rows > 0) {
                                // Mengambil hasil query
                                $row = $result3->fetch_assoc();
                                echo $row["total_rows"] . " ";
                            } else {
                                echo "0 ";
                            }
                            ?>
                            Driver
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-solid fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Client
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <?php
                                    if ($result4->num_rows > 0) {
                                        // Mengambil hasil query
                                        $row = $result4->fetch_assoc();
                                        echo $row["total_rows"] . " ";
                                    } else {
                                        echo "0 ";
                                    }
                                    ?>
                                    Client
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-regular fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pengiriman Berhasil</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            if ($result2->num_rows > 0) {
                                // Mengambil hasil query
                                $row = $result2->fetch_assoc();
                                echo $row["jumlah_data"];
                            } else {
                                echo "0";
                            }
                            ?>
                            Pengiriman Sukses
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>