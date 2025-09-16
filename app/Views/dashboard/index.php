<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Dashboard</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">

        <!-- Statistic cards -->
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $countPegawai ?></h3>
                        <p>Pegawai</p>
                    </div>
                    <div class="icon"><i class="fas fa-user"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $countDepartemen ?></h3>
                        <p>Departemen</p>
                    </div>
                    <div class="icon"><i class="fas fa-building"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $countKeahlian ?></h3>
                        <p>Keahlian</p>
                    </div>
                    <div class="icon"><i class="fas fa-graduation-cap"></i></div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header"><h3 class="card-title">Gender</h3></div>
                    <div class="card-body">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header"><h3 class="card-title">Pegawai per Departemen</h3></div>
                    <div class="card-body">
                        <canvas id="departemenChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Gender Pie Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($genderLabels) ?>,
            datasets: [{
                data: <?= json_encode($genderData) ?>,
                backgroundColor: ['#007bff', '#dc3545'] // blue for Pria, red for Wanita
            }]
        },
        options: { responsive: true }
    });

    // Departemen Bar Chart
    const departemenCtx = document.getElementById('departemenChart').getContext('2d');
    new Chart(departemenCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($departemenLabels) ?>,
            datasets: [{
                label: 'Jumlah Pegawai',
                data: <?= json_encode($departemenData) ?>,
                backgroundColor: '#28a745'
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
<?= $this->endSection() ?>
