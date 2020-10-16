<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Penjualan (Bulan Ini)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $hariini; ?> Transaksi</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Penjualan (Bulan Ini)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($totbulan['total'], 2); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Penjualan (Hari Ini)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($tothari['total'], 2); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Saldo Sekarang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($totbulan['total'], 2); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">PENJUALAN HARI INI</h2>
                <div class="table-rep-plugin">
                    <div class="table-responsive mb-0">
                        <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                            <thead style="background-color: #0085cd;color:white">
                                <tr>
                                    <th>No Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Potongan</th>
                                    <th>Bayar</th>
                                    <th>Sisa Bayar</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total          = 0;
                                $potongan       = 0;
                                $jumlahbayar    = 0;
                                $sisabayar      = 0;
                                foreach ($data as $d) {
                                    if ($d->jumlahbayar >= $d->total - $d->potongan) {
                                    } else {
                                        $total              += $d->total;
                                        $jumlahbayar        += $d->jumlahbayar;
                                        $sisabayar          += $d->total - $d->jumlahbayar;
                                        $potongan           += $d->potongan;
                                ?>
                                        <tr>
                                            <td><?php echo $d->no_fak_penj; ?></td>
                                            <td><?php echo $d->tgl_transaksi; ?></td>
                                            <td align="right"><?php echo number_format($d->total); ?></td>
                                            <td align="right"><?php echo number_format($d->potongan); ?></td>
                                            <td align="right"><?php echo number_format($d->jumlahbayar); ?></td>
                                            <td align="right"><?php echo number_format($d->total - $d->jumlahbayar); ?></td>
                                            <td><?php echo $d->keterangan; ?></td>
                                            <td>
                                                <?php if ($d->jumlahbayar >= $d->total - $d->potongan) {
                                                    echo "<a href'#' class='btn btn-info btn-sm' style='color:blue; font-weight: bold'>Lunas</a> ";
                                                } else {
                                                    echo "<a href'#' class='btn btn-warning btn-sm' style='color:red; font-weight: bold'>Belum Lunas</a> ";
                                                } ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-info btn-sm detail" href="#" data-kode="<?php echo $d->no_fak_penj; ?>"><i class="mdi mdi-eye"></i></a>
                                                <?php if ($d->jumlahbayar >= $d->total - $d->potongan) { ?>
                                                <?php } else { ?>
                                                    <a class="btn btn-primary btn-sm bayar" href="#" data-kode="<?php echo $d->no_fak_penj; ?>"><i class="mdi mdi-file-document"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }
                                if ($total != "0") {
                                    ?>
                                    <thead style="background-color: #0085cd;color:white">
                                        <tr>
                                            <td colspan="2">Total</td>
                                            <td align="right"><?php echo number_format($total); ?></td>
                                            <td align="right"><?php echo number_format($potongan); ?></td>
                                            <td align="right"><?php echo number_format($jumlahbayar); ?></td>
                                            <td align="right"><?php echo number_format($sisabayar); ?></td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </thead>
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
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Detail Penjualan</h5>
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

<div class="modal fade" id="bayarpiutang" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Input Pembayaran Piutang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loadbayarpiutang">

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
            var no_fak_penj = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/input_bayar_piutang',
                data: {
                    no_fak_penj: no_fak_penj
                },
                cache: false,
                success: function(respond) {
                    $("#loadbayarpiutang").html(respond);
                    $("#bayarpiutang").modal("show");
                }
            });
        });

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