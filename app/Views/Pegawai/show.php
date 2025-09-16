<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0"><?= esc($title) ?></h1>
        <a href="<?= site_url('pegawai') ?>" class="btn btn-secondary mt-2">Kembali</a>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td><?= $pegawai['id'] ?></td>
            </tr>
            <tr>
                <th>Nama</th>
                <td><?= esc($pegawai['name']) ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>
                    <?php if($pegawai['gender'] == 'P'): ?>
                        <span class="badge bg-primary fs-5 px-3 py-2">Pria</span>
                    <?php else: ?>
                        <span class="badge bg-pink fs-5 px-3 py-2">Wanita</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Departemen</th>
                <td><?= esc($pegawai['departemenid']) ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?= esc($pegawai['address']) ?></td>
            </tr>
            <tr>
                <th>Keahlian</th>
                <td>
                    <?php foreach($pegawai['keahlianNames'] as $k): ?>
                        <span class="badge bg-info fs-5 px-3 py-2"><?= esc($k) ?></span>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?= $pegawai['active'] == 1 ? 'Active' : 'Non Active' ?></td>
            </tr>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
