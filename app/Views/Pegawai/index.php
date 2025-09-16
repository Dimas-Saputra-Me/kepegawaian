<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Data Pegawai</h1>
        <a href="<?= site_url('pegawai/new') ?>" class="btn btn-primary mt-2">Tambah Pegawai</a>
        <a href="<?= site_url('pegawai/export/csv') ?>" class="btn btn-success mt-2">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <table class="table table-bordered table-striped" id="pegawaiTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Gender</th>
                    <th>Departemen</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // DataTable
    let table = $('#pegawaiTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= site_url('pegawai') ?>",
        order: [],
        columns: [
            { data: 'no', orderable: true},
            { data: 'name' },
            { data: 'gender', render: function(data){
                return data == "P" ? "Pria" : "Wanita";
            }},
            { data: 'departemen_name' },
            { data: 'active', render: function(data){
                return data == 1 ? 'Active' : 'Non Active';
            }},
            { data: 'actions', orderable: false, searchable: false }
        ]
    });

    // handle delete
    $('#pegawaiTable').on('click', '.deleteBtn', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Yakin hapus?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('pegawai') ?>/" + id,
                    type: "DELETE",
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: 'Data berhasil dihapus.',
                            timer: 1000,
                            showConfirmButton: false
                        });
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Oops!', 'Gagal menghapus data.', 'error');
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
