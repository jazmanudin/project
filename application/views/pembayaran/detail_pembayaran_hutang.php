<div class="table-rep-plugin">
    <div class="table-responsive mb-0">
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead id="datatable" style="background-color:#0085cd;color:white;">
                <tr>
                    <th style="width: 15%;">Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th style="width: 15%;">Tanggal Bayar</th>
                    <th style="width: 10%;">No Bukti</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th><?php echo $detail['kode_supplier'];?></th>
                    <th><?php echo $detail['nama_supplier'];?></th>
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
                        <td><a href="#" class="detailpembelian" data-kode="<?php echo $d->no_fak_pemb; ?>"><?php echo $d->no_fak_pemb; ?></a></td>
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
        <table class="table table-striped table-bordered table-hover table-sm" id="loaddetailpembelian">
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('.detailpembelian').click(function(e) {
            e.preventDefault();
            var no_fak_pemb = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembayaran/detail_pembelian',
                data: {
                    no_fak_pemb: no_fak_pemb
                },
                cache: false,
                success: function(respond) {
                    $("#loaddetailpembelian").html(respond);
                }
            });

        });

    });
</script>