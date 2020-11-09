<thead id="datatable" style="background-color:#0085cd;color:white;">
    <tr>
        <th colspan="6">Detail Pembelian</th>
    </tr>
    <tr>
        <th style="width: 5%;">Kode</th>
        <th style="width: 40%;">Nama Barang</th>
        <th style="width: 5%;">Satuan</th>
        <th style="width: 8%;">Jumlah</th>
        <th style="width: 8%;">Harga</th>
        <th style="width: 8%;">Total</th>
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
            <td><?php echo $d->satuan; ?></td>
            <td align="center"><?php echo number_format($d->qty); ?></td>
            <td align="right"><?php echo number_format($d->harga_modal); ?></td>
            <td align="right"><?php echo number_format($d->harga_modal * $d->qty); ?></td>
        </tr>
    <?php } ?>
    <thead>
        <tr>
            <th colspan="5" style="text-align: center;">Total</th>
            <th style="text-align:right"><?php echo number_format($total); ?></th>
        </tr>
    </thead>
</tbody>