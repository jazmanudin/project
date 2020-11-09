<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">DATA PEMBELIAN</h2>
                <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>pembelian/view_pembelian" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <input class="form-control form-control-sm" value="<?php echo $no_fak_pemb; ?>" name="no_fak_pemb" placeholder="No Faktur">
                            </div>
                            <div class="form-group">
                                <select class="selectize" id="kode_supplier" name="kode_supplier" tabindex="1">
                                    <option value="">-- Pilih Supplier --</option>
                                    <?php foreach ($supplier->result() as $s) { ?>
                                        <option <?php if ($kode_supplier == $s->kode_supplier) {
                                                    echo "selected";
                                                } ?> value="<?php echo $s->kode_supplier; ?>"><?php echo $s->nama_supplier; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo $dari; ?>" name="dari" id="dari" placeholder="Dari" class="form-control form-control-sm datepicker-here" data-language="en" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo $sampai; ?>" name="sampai" id="sampai" placeholder="Sampai" class="form-control form-control-sm datepicker-here" data-language="en" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" align="right">
                                <button type="submit" name="submit" class="btn btn-info btn-sm btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-rep-plugin">
                    <a href="<?php echo base_url(); ?>pembelian/input_pembelian" class="btn btn-primary btn-sm input">Tambah Data</a>
                    <div class="table-responsive mb-0">
                        <table class="table table-striped table-bordered table-hover table-sm">
                            <thead style="background-color: #0085cd;color:white">
                                <tr>
                                    <th style="width: 8%;">No Faktur</th>
                                    <th style="width: 7%;">No PO</th>
                                    <th style="width: 7%;">Tanggal</th>
                                    <th style="width: 15%;">Supplier</th>
                                    <th style="width: 8%;">Total</th>
                                    <th style="width: 8%;">Potongan</th>
                                    <th style="width: 8%;">Bayar</th>
                                    <th style="width: 8%;">Sisa Bayar</th>
                                    <th>Keterangan</th>
                                    <th style="width: 5%;">PPN</th>
                                    <th style="width: 5%;">J. Transaksi</th>
                                    <th style="width: 5%;">Status</th>
                                    <th style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $d) {
                                ?>
                                    <tr>
                                        <td><?php echo $d['no_fak_pemb']; ?></td>
                                        <td><?php echo $d['no_po']; ?></td>
                                        <td><?php echo $d['tgl_transaksi']; ?></td>
                                        <td><?php echo $d['nama_supplier']; ?></td>
                                        <td align="right"><?php echo number_format($d['total']); ?></td>
                                        <td align="right"><?php echo number_format($d['potongan']); ?></td>
                                        <td align="right"><?php echo number_format($d['jumlahbayar']); ?></td>
                                        <td align="right"><?php echo number_format($d['total'] - $d['potongan'] - $d['jumlahbayar']); ?></td>
                                        <td><?php echo $d['keterangan']; ?></td>
                                        <td><?php echo $d['ppn']; ?></td>
                                        <td><?php echo $d['jenis_transaksi']; ?></td>
                                        <td>
                                            <?php if ($d['jumlahbayar'] >= $d['total'] - $d['potongan']) {
                                                echo "<a href'#' class='btn btn-info btn-sm' style='color:white; font-weight: bold'>Lunas</a> ";
                                            } else {
                                                echo "<a href'#' class='btn btn-danger btn-sm' style='color:white; font-weight: bold'>Belum Lunas</a> ";
                                            } ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm detail" href="#" data-supp="<?php echo $d['kode_supplier']; ?>" data-kode="<?php echo $d['no_fak_pemb']; ?>"><i class="mdi mdi-eye"></i></a>
                                            <a class="btn btn-danger btn-sm delete" style="color:white;" data-href="<?php echo base_url(); ?>pembelian/hapus_pembelian/<?php echo $d['no_fak_pemb']; ?>"><i class="fa fa-trash"></i></a>
                                            <?php if ($d['jenis_transaksi'] == "Tunai") { ?>
                                            <?php } else { ?>
                                                <a class="btn btn-warning btn-sm" style="color:white;" href="<?php echo base_url(); ?>pembelian/edit_pembelian/<?php echo $d['no_fak_pemb']; ?>"><i class="mdi mdi-pencil"></i></a>
                                            <?php } ?>
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

<div class="modal fade" id="detailpembelian" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loaddetailpembelian">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bayarhutang" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Input Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loadbayarhutang">

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {

        $('.bayar').click(function(e) {
            e.preventDefault();
            var no_fak_pemb = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/input_bayar_hutang',
                data: {
                    no_fak_pemb: no_fak_pemb
                },
                cache: false,
                success: function(respond) {
                    $("#loadbayarhutang").html(respond);
                    $("#bayarhutang").modal("show");
                }
            });
        });

        $('.detail').click(function(e) {
            e.preventDefault();
            var no_fak_pemb = $(this).attr('data-kode');
            var kode_supplier = $(this).attr('data-supp');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/detail_pembelian',
                data: {
                    kode_supplier: kode_supplier,
                    no_fak_pemb: no_fak_pemb
                },
                cache: false,
                success: function(respond) {
                    $("#loaddetailpembelian").html(respond);
                    $("#detailpembelian").modal("show");
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
            })
        });

    });
</script>