<div class="table-rep-plugin">
    <div class="table-responsive mb-0">
        <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
            <thead style="background-color: #0085cd;color:white">
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Keterangan</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($data as $d) {
                    $total += $d->qty * $d->harga_modal;
                ?>
                    <tr>
                        <td><?php echo $d->kode_barang; ?></td>
                        <td><?php echo $d->nama_barang; ?></td>
                        <td><?php echo $d->keterangan; ?></td>
                        <td align="center"><?php echo number_format($d->qty); ?></td>
                        <td align="right"><?php echo number_format($d->harga_modal); ?></td>
                        <td align="right"><?php echo number_format($d->harga_modal * $d->qty); ?></td>
                        <td></td>
                    </tr>
                <?php } ?>
                <thead style="background-color: #0085cd;color:white">
                    <tr>
                        <th colspan="5">Total</th>
                        <th style="text-align:right"><?php echo number_format($total); ?></th>
                    </tr>
                </thead>
            </tbody>
        </table>
    </div>
</div>