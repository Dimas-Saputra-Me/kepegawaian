<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h1>Laporan Hasil Tes</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-success text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pegawai 100% Benar</h5>
                    <p class="card-text display-4"><?= $benarSemua ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-info text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Rata-rata Nilai</h5>
                    <p class="card-text display-4"><?= $rataRata ?>%</p>
                </div>
            </div>
        </div>
    </div>

    <h3>Pertanyaan & Statistik Jawaban Benar</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th>Jumlah Pegawai Benar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($statPertanyaan as $i => $row): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= esc($row['question']) ?></td>
                    <td><?= $row['jumlah_benar'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
