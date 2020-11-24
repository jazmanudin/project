<div class="row">
    <div class="col-lg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">FORM PELANGGAN</h2>
                <form autocomplete="off" id="form" method="POST" enctype="multipart/form-data" <div class="form-group">
                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input type="hidden" name="kode_pelanggan" id="kode_pelanggan" class="form-control form-control-sm" placeholder="Kode pelanggan" />
                        <input type="text" required name="nama_pelanggan" id="nama_pelanggan" class="form-control form-control-sm" placeholder="Nama pelanggan" />
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" required name="alamat" id="alamat" class="form-control form-control-sm" placeholder="Alamat" />
                    </div>
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="number" required name="no_hp" id="no_hp" class="form-control form-control-sm" placeholder="No HP" />
                    </div>
                    <div class="form-group">
                        <label>Jatuh Tempo (Hari)</label>
                        <input type="number" required name="jatuh_tempo" id="jatuh_tempo" class="form-control form-control-sm" placeholder="Jatuh Tempo (Hari)" />
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" required name="keterangan" id="keterangan" class="form-control form-control-sm" placeholder="Keterangan" />
                    </div>
                    <div class="form-group mb-0">
                        <a class="btn btn-info btn-sm btn-block" href="#" id="simpanpelanggan"><i class="fa fa-save"></i> Simpan</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-md-7">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">DATA PELANGGAN</h2>
                <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>pelanggan/view_pelanggan" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <input class="form-control form-control-sm" value="<?php echo $kode_pelanggan; ?>" name="kode_pelanggan" placeholder="Kode Pelanggan">
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-sm" value="<?php echo $nama_pelanggan; ?>" name="nama_pelanggan" placeholder="Nama Pelanggan">
                            </div>
                            <div class="form-group" align="right">
                                <button type="submit" name="submit" class="btn btn-info btn-sm btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-rep-plugin">
                    <div class="table-responsive mb-0">
                        <table id="table" class="table table-striped table-bordered table-hover table-sm">
                            <thead style="background-color: #0085cd;color:white">
                                <tr>
                                    <th style="width: 15%;">Kode Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Alamat</th>
                                    <th>No HP</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Keterangan</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $d) { ?>
                                    <tr>
                                        <td><?php echo $d->kode_pelanggan; ?></td>
                                        <td><?php echo $d->nama_pelanggan; ?></td>
                                        <td><?php echo $d->alamat; ?></td>
                                        <td><?php echo $d->no_hp; ?></td>
                                        <td><?php echo $d->jatuh_tempo; ?> Hari</td>
                                        <td><?php echo $d->keterangan; ?></td>
                                        <td>
                                            <a class="btn btn-danger btn-sm delete" href="#" data-href="<?php echo base_url(); ?>pelanggan/hapus_pelanggan/<?php echo $d->kode_pelanggan; ?>"><i class="mdi mdi-trash-can"></i></a>
                                            <a class="btn btn-warning btn-sm edit" href="#" data-tempo="<?php echo $d->jatuh_tempo; ?>" data-kode="<?php echo $d->kode_pelanggan; ?>" data-nama="<?php echo $d->nama_pelanggan; ?>" data-ket="<?php echo $d->keterangan; ?>" data-alamat="<?php echo $d->alamat; ?>" data-nohp="<?php echo $d->no_hp; ?>"><i class="mdi mdi-pencil"></i></a>
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

        $('#simpanpelanggan').click(function(e) {
            e.preventDefault();
            var kode_pelanggan = $('#kode_pelanggan').val();
            var nama_pelanggan = $('#nama_pelanggan').val();
            var alamat = $('#alamat').val();
            var no_hp = $('#no_hp').val();
            var keterangan = $('#keterangan').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pelanggan/insert_pelanggan',
                data: {
                    kode_pelanggan: kode_pelanggan,
                    nama_pelanggan: nama_pelanggan,
                    alamat: alamat,
                    no_hp: no_hp,
                    keterangan: keterangan
                },
                cache: false,
                success: function(respond) {
                    location.reload();
                }
            });
        });

        $('.edit').click(function(e) {
            e.preventDefault();
            var kode_pelanggan = $(this).attr('data-kode');
            var nama_pelanggan = $(this).attr('data-nama');
            var alamat = $(this).attr('data-alamat');
            var no_hp = $(this).attr('data-nohp');
            var tempo = $(this).attr('data-tempo');
            var keterangan = $(this).attr('data-keterangan');
            $('#keterangan').val(keterangan);
            $('#nama_pelanggan').val(nama_pelanggan);
            $('#alamat').val(alamat);
            $('#jatuh_tempo').val(tempo);
            $('#kode_pelanggan').val(kode_pelanggan);

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