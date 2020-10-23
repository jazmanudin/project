<div class="table-rep-plugin">
    <div class="table-responsive mb-0">
        <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
            <thead style="background-color: #0085cd;color:white">
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Diskon (Rp)</th>
                    <th>Total</th>
                    <th>Keterangan</th>
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
                        <td><?php echo number_format($d->qty); ?></td>
                        <td align="right"><?php echo number_format($d->harga_modal); ?></td>
                        <td align="right"><?php echo number_format($d->diskon); ?></td>
                        <td align="right"><?php echo number_format($d->harga_modal * $d->qty); ?></td>
                        <td><?php echo $d->keterangan; ?></td>
                        <td></td>
                    </tr>
                <?php } ?>
                <thead style="background-color: #0085cd;color:white">
                    <tr>
                        <th colspan="5">Total</th>
                        <th style="text-align:right"><?php echo number_format($total); ?></th>
                        <th></th>
                    </tr>
                </thead>
            </tbody>
        </table>
    </div>
</div>