<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">DATA PENJUALAN</h2>
                <div class="table-rep-plugin">
                    <a href="<?php echo base_url(); ?>penjualan/input_penjualan" class="btn btn-primary btn-sm input">Tambah Data</a>
                    <div class="table-responsive mb-0">
                        <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Keterangan</th>
                                    <th>Bayar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $d) { ?>
                                    <tr>
                                        <td><?php echo $d->no_fak_penj; ?></td>
                                        <td><?php echo $d->tgl_transaksi; ?></td>
                                        <td><?php echo $d->kode_pelanggan; ?></td>
                                        <td><?php echo $d->keterangan; ?></td>
                                        <td><?php echo $d->jumlahbayar; ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a data-kode="<?php echo $d->no_fak_penj; ?>" class="btn btn-outline-secondary btn-sm detail" title="View">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                                <a class="btn btn-outline-secondary btn-sm" title="Edit">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <a href="#" class="btn btn-outline-secondary btn-sm delete" data-href="<?php echo base_url(); ?>penjualan/hapus_penjualan/<?php echo $d->no_fak_penj; ?>" title="Delete">
                                                    <i class="mdi mdi-trash-can"></i>
                                                </a>
                                            </div>
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

<div class="modal fade" id="detailpenjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Detail penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loaddetailpenjualan">

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
            var no_fak_penj = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/detail_penjualan',
                data: {
                    no_fak_penj: no_fak_penj
                },
                cache: false,
                success: function(respond) {
                    $("#loaddetailpenjualan").html(respond);
                    $("#detailpenjualan").modal("show");
                }
            });
        });

    });
</script>