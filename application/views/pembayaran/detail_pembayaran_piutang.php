<div class="table-rep-plugin">
    <div class="table-responsive mb-0">
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead id="datatable" style="background-color:#0085cd;color:white;">
                <tr>
                    <th style="width: 15%;">Kode</th>
                    <th>Nama Pelanggan</th>
                    <th style="width: 15%;">Tanggal Bayar</th>
                    <th style="width: 10%;">No Bukti</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th><?php echo $detail['kode_pelanggan'];?></th>
                    <th><?php echo $detail['nama_pelanggan'];?></th>
                    <th><?php echo $detail['tgl_bayar'];?></th>
                    <th><?php echo $detail['nobukti'];?></th>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead id="datatable" style="background-color:#0085cd;color:white;">
                <tr>
                    <th style="width: 10%;">No</th>
                    <th style="width: 15%;">No Faktur</th>
                    <th>Keterangan</th>
                    <th style="width: 15%;">Jumlah Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total = 0;
                foreach ($data as $d) {
                    $total += $d->jumlah;
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><a href="#" class="detailpenjualan" data-kode="<?php echo $d->no_fak_penj; ?>"><?php echo $d->no_fak_penj; ?></a></td>
                        <td><?php echo $d->keterangan; ?></td>
                        <td align="right"><?php echo number_format($d->jumlah); ?></td>
                    </tr>
                <?php } ?>
                <thead>
                    <tr>
                        <th colspan="3" style="text-align: center;">Total</th>
                        <th style="text-align:right"><?php echo number_format($total); ?></th>
                    </tr>
                </thead>
            </tbody>
        </table>
        <br>
        <table class="table table-striped table-bordered table-hover table-sm" id="loaddetailpenjualan">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('.detailpenjualan').click(function(e) {
            e.preventDefault();
            var no_fak_penj = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembayaran/detail_penjualan',
                data: {
                    no_fak_penj: no_fak_penj
                },
                cache: false,
                success: function(respond) {
                    $("#loaddetailpenjualan").html(respond);
                }
            });

        });

    });
</script>