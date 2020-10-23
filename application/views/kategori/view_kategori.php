<div class="row">
    <div class="col-lg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">FORM KATEGORI</h2>
                <form autocomplete="off" id="form" method="POST" enctype="multipart/form-data" <div class="form-group">
                    <div class="form-group">
                        <label>Nama kategori</label>
                        <input type="hidden" name="kode_kategori" id="kode_kategori" class="form-control form-control-sm" placeholder="Kode Kategori" />
                        <input type="text" name="nama_kategori" id="nama_kategori" class="data_kosong form-control form-control-sm" placeholder="Nama Kategori" />
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="ket" id="ket" class="data_kosong form-control form-control-sm" placeholder="Keterangan" />
                    </div>
                    <div class="form-group mb-0">
                        <a class="btn btn-info btn-sm btn-block" href="#" id="simpankategori"><i class="fa fa-save"></i> Simpan</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-md-7">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">DATA KATEGORI</h2>
                <div class="table-rep-plugin">
                    <div class="table-responsive mb-0">
                        <table id="table" class="table table-striped table-bordered table-hover table-sm">
                            <thead style="background-color: #0085cd;color:white">
                                <tr>
                                    <th style="width: 15%;">Kode Kategori</th>
                                    <th>Nama Kategori</th>
                                    <th>Keterangan</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $d) { ?>
                                    <tr>
                                        <td><?php echo $d->kode_kategori; ?></td>
                                        <td><?php echo $d->nama_kategori; ?></td>
                                        <td><?php echo $d->ket; ?></td>
                                        <td>
                                            <a class="btn btn-danger btn-sm delete" href="#" data-href="<?php echo base_url(); ?>kategori/hapus_kategori/<?php echo $d->kode_kategori; ?>"><i class="mdi mdi-trash-can"></i></a>
                                            <a class="btn btn-warning btn-sm edit" href="#" data-kode="<?php echo $d->kode_kategori;?>" data-nama="<?php echo $d->nama_kategori;?>" data-ket="<?php echo $d->ket;?>"><i class="mdi mdi-pencil"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('#simpankategori').click(function(e) {
            e.preventDefault();
            var kode_kategori = $('#kode_kategori').val();
            var nama_kategori = $('#nama_kategori').val();
            var ket           = $('#ket').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>kategori/insert_kategori',
                data: {
                    kode_kategori: kode_kategori,
                    nama_kategori: nama_kategori,
                    ket: ket
                },
                cache: false,
                success: function(respond) {
                    location.reload();
                }
            });
        });

        $('.edit').click(function(e) {
            e.preventDefault();
            var kode_kategori = $(this).attr('data-kode');
            var nama_kategori = $(this).attr('data-nama');
            var ket = $(this).attr('data-ket');
            $('#ket').val(ket);
            $('#nama_kategori').val(nama_kategori);
            $('#kode_kategori').val(kode_kategori);
            
        });

        $('.delete').click(function(e) {
            e.preventDefault();
            var getLink = $(this).attr('data-href');
            Swal.fire({
                title: 'Yakin Mau di Hapus??',
                text: "Data tidak akan kembali lagi..",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.dismiss) {
                    Swal.fire(
                        'Batal',
                        'Batal di Hapus, Data Masih Aman',
                        'error'
                    )
                } else {
                    Swal.fire(
                        'Hapus',
                        'Berhasil di Hapus',
                        'success'
                    )
                    window.location.href = getLink
                }
            })
        });

    });
</script>