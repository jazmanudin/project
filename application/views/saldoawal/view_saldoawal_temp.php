<?php
$total = 0;
foreach ($data->result() as $d) {
    $pemasukan   = $d->qtypembelian + $d->qtyreturkembali + $d->qtymasuklainnya;
    $pengeluaran = $d->qtypenjualan + $d->qtyretur + $d->qtybuang + $d->qtykeluarlainnya;
    $qty         = $d->qtysaldoawal + $pemasukan - $pengeluaran;

?>
    <tr>
        <td hidden><input value="<?php echo $d->kode_barang; ?>" name="kode_barang[]"></td>
        <td><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->satuan; ?></td>
        <td><input class="form-control form-control-sm qty" value="<?php echo $qty;?>" placeholder="Qty" name="qty[]"></td>
    </tr>
<?php } ?>
<script>
    $(document).ready(function() {

        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }

    });
</script>