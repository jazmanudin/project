<?php
$total = 0;
foreach ($data->result() as $d) {
?>
    <tr>
        <td style="width: 10%;"><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td style="width: 10%;"><?php echo $d->satuan; ?></td>
        <td style="width: 10%;" align="center"><?php echo number_format($d->qty); ?></td>
        <td style="width: 3%;">
            <a class="btn btn-sm btn-warning edit" href="#" data-satuan="<?php echo $d->satuan; ?>" data-qty="<?php echo $d->qty; ?>" data-nama="<?php echo $d->nama_barang; ?>" data-kode="<?php echo $d->kode_barang; ?>"><i class="mdi mdi-pencil"></i></a>
        </td>
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

        $('.edit').click(function(e) {
            e.preventDefault();
            var kode_barang = $(this).attr('data-kode');
            var nama_barang = $(this).attr('data-nama');
            var qty = $(this).attr('data-qty');
            var satuan = $(this).attr('data-satuan');

            $('#kode_barang').val(kode_barang);
            $('#nama_barang').val(nama_barang);
            $('#satuan').val(satuan);
            $('#qty').val(formatAngka(qty));
            $('#qty').focus();

        });

    });
</script>