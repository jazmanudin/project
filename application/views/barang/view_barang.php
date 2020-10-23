<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">DATA BARANG</h2>
                <div class="table-rep-plugin">
                    <a href="<?php echo base_url(); ?>barang/input_barang" class="btn btn-primary btn-sm input">Tambah Data</a>
                    <div class="table-responsive mb-0">
                        <table id="table" class="table table-striped table-bordered table-hover table-sm">
                            <thead style="background-color: #0085cd;color:white">
                                <tr>
                                    <th style="width: 5%;">Kode</th>
                                    <th style="width: 20%;">Nama</th>
                                    <th style="width: 5%;">Satuan</th>
                                    <th style="width: 10%;">Kategori</th>
                                    <th style="width: 10%;">Jenis Barang</th>
                                    <th style="width: 8%;">Harga Modal</th>
                                    <th style="width: 8%;">Harga Jual</th>
                                    <th style="width: 8%;">Diskon</th>
                                    <th style="width: 5%;">Stok</th>
                                    <th>Keterangan</th>
                                    <th style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $d) { ?>
                                    <tr>
                                        <td><?php echo $d->kode_barang; ?></td>
                                        <td><?php echo $d->nama_barang; ?></td>
                                        <td><?php echo $d->satuan; ?></td>
                                        <td><?php echo $d->nama_kategori; ?></td>
                                        <td><?php echo $d->jenis_barang; ?></td>
                                        <td align="right"><?php echo number_format($d->harga_modal); ?></td>
                                        <td align="right"><?php echo number_format($d->harga); ?></td>
                                        <td align="right"><?php echo number_format($d->diskon); ?></td>
                                        <td align="right"><?php echo number_format($d->stok); ?></td>
                                        <td><?php echo $d->keterangan; ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm detail" href="#" data-kode="<?php echo $d->kode_barang; ?>"><i class="mdi mdi-eye"></i></a>
                                            <a class="btn btn-danger btn-sm delete" href="#" data-href="<?php echo base_url(); ?>barang/hapus_barang/<?php echo $d->kode_barang; ?>"><i class="mdi mdi-trash-can"></i></a>
                                            <a class="btn btn-warning btn-sm" href="<?php echo base_url(); ?>barang/edit_barang/<?php echo $d->kode_barang; ?>"><i class="mdi mdi-pencil"></i></a>
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

<div class="modal fade" id="detailbarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Detail Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loaddetailbarang">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {

        $('.detail').click(function(e) {
            e.preventDefault();
            var kode_barang = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>barang/detail_barang',
                data: {
                    kode_barang: kode_barang
                },
                cache: false,
                success: function(respond) {
                    $("#loaddetailbarang").html(respond);
                    $("#detailbarang").modal("show");
                }
            });
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
                location.reload();
            })
        });

    });
</script>