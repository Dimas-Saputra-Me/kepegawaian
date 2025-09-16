<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0"><?= $mode === 'create' ? 'Tambah Pegawai' : 'Edit Pegawai' ?></h1>
        <a href="<?= site_url('pegawai') ?>" class="btn btn-secondary mt-2">Kembali</a>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <form id="pegawaiForm">
            <?php if($mode === 'edit'): ?>
                <input type="hidden" name="_method" value="PUT">
            <?php endif; ?>

            <input type="hidden" name="id" value="<?= old('id', $pegawai['id'] ?? '') ?>">

            <!-- Nama -->
            <div class="form-group">
                <label for="name" required>Nama</label>
                <input type="text" name="name" id="name" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" 
                    value="<?= old('name', $pegawai['name'] ?? '') ?>" 
                    data-toggle="tooltip" title="Masukkan nama pegawai" required>
                <?php if(session('errors.name')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.name') ?>
                    </div>
                <?php endif; ?>
            </div>

            
            <!-- Gender -->
            <div class="form-group">
                <label>Gender</label>
                <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                    <label class="btn <?= ($pegawai['gender'] ?? old('gender')) == 'P' ? 'btn-primary active' : 'btn-outline-primary' ?> flex-fill"
                        data-toggle="tooltip" title="Pilih Pria">
                        <input type="radio" name="gender" value="P" autocomplete="off" <?= ($pegawai['gender'] ?? old('gender')) == 'P' ? 'checked' : '' ?> required> Pria
                    </label>
                    <label class="btn <?= ($pegawai['gender'] ?? old('gender')) == 'W' ? 'btn-danger active' : 'btn-outline-danger' ?> flex-fill"
                        data-toggle="tooltip" title="Pilih Wanita">
                        <input type="radio" name="gender" value="W" autocomplete="off" <?= ($pegawai['gender'] ?? old('gender')) == 'W' ? 'checked' : '' ?> required> Wanita
                    </label>
                </div>
                <?php if(session('errors.gender')): ?>
                    <small class="text-danger"><?= session('errors.gender') ?></small>
                <?php endif; ?>
            </div>



            <!-- Departemen -->
            <div class="form-group">
                <label>Departemen</label>
                <select name="departemenid" class="form-control" required>
                    <?php foreach($departemen as $d): ?>
                        <option value="<?= $d['id'] ?>" <?= isset($pegawai['departemenid']) && $pegawai['departemenid']==$d['id']?'selected':'' ?>>
                            <?= $d['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Alamat -->
            <div class="form-group">
                <label for="address">Alamat</label>
                <input name="address" id="address" 
                        class="form-control <?= session('errors.address') ? 'is-invalid' : '' ?>" 
                        required
                        value="<?= old('address', $pegawai['address'] ?? '') ?>"
                        data-toggle="tooltip" title="Masukkan alamat maksimal 200 karakter">
                <?php if(session('errors.address')): ?>
                    <div class="invalid-feedback"><?= session('errors.address') ?></div>
                <?php endif; ?>
            </div>

            <!-- Keahlian -->
            <div class="form-group">
                <label for="keahlian">Keahlian</label>
                <select name="keahlian[]" id="keahlian" class="form-control <?= session('errors.keahlian') ? 'is-invalid' : '' ?>" multiple required
                data-toggle="tooltip" title="Tekan Ctrl/Cmd untuk memilih lebih dari satu keahlian">
                    <?php foreach($allKeahlian as $k): ?>
                        <option value="<?= $k['id'] ?>" 
                            <?= in_array($k['id'], old('keahlian', explode(',', $pegawai['keahlian'] ?? ''))) ? 'selected' : '' ?>>
                            <?= esc($k['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if(session('errors.keahlian')): ?>
                    <div class="invalid-feedback"><?= session('errors.keahlian') ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary"><?= $mode === 'create' ? 'Simpan' : 'Update' ?></button>
            <a href="<?= site_url('pegawai') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// On Submit (create/update)
$("#pegawaiForm").on("submit", function(e) {
    e.preventDefault();

    let formData = $(this).serialize();
    let id = $("input[name='id']").val();
    let url = id 
        ? "<?= site_url('pegawai') ?>/" + id   // update
        : "<?= site_url('pegawai') ?>";        // create
    let method = "POST";

    $.ajax({
        url: url,
        type: method,
        data: formData,
        success: function(res) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data berhasil disimpan.',
                showConfirmButton: false,
                timer: 300
            }).then(() => {
                window.location.href = "<?= site_url('pegawai') ?>";
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan: ' + xhr.responseText
            });
        }
    });
});

$(document).ready(function() {
    // Gender Field
     $('.btn-group-toggle .btn').click(function() {
        var $btn = $(this);
        var $group = $btn.closest('.btn-group');

        $group.find('.btn').each(function() {
            var $b = $(this);
            var color = $b.hasClass('btn-primary') || $b.hasClass('btn-outline-primary') ? 'primary' : 'danger';
            $b.removeClass('active btn-primary btn-danger').addClass('btn-outline-' + color);
        });

        if ($btn.find('input').val() === 'P') {
            $btn.removeClass('btn-outline-primary').addClass('btn-primary active');
        } else {
            $btn.removeClass('btn-outline-danger').addClass('btn-danger active');
        }

        // Update radio input
        $btn.find('input').prop('checked', true);
    });

    //  Keahlian Field
    $('#keahlian').select2({
        placeholder: "Pilih keahlian...",
        width: '100%'
    });
});
</script>
<?= $this->endSection() ?>
