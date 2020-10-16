<div class="table-rep-plugin">
    <div class="table-responsive mb-0">
        <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
            <thead style="background-color: #0085cd;color:white">
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($data as $d) {
                    $total += $d->qty * $d->harga;
                ?>
                    <tr>
                        <td><?php echo $d->nama_barang; ?></td>
                        <td><?php echo number_format($d->qty); ?></td>
                        <td align="right"><?php echo number_format($d->harga); ?></td>
                        <td align="right"><?php echo number_format($d->harga * $d->qty); ?></td>
                    </tr>
                <?php } ?>
                <thead style="background-color: #0085cd;color:white">
                    <tr>
                        <th colspan="3">Total</th>
                        <th style="text-align:right"><?php echo number_format($total); ?></th>
                    </tr>
                </thead>
            </tbody>
        </table>
    </div>
</div>