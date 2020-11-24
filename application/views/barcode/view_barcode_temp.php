<?php
$total = 0;
foreach ($data->result() as $d) {
    $countdata = $data->num_rows();
?>
    <tr>
        <td hidden><input value="<?php echo $d->kode_barang; ?>" name="kode_barang[]"></td>
        <td><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->satuan; ?></td>
        <td><?php echo $d->nama_kategori; ?></td>
    </tr>
<?php } ?>
<input type="hidden" value="<?php if (!empty($countdata)) {
                                echo $countdata;
                            } ?>" id="countdata" class="form-control">
<script>
    $(document).ready(function() {

        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }

        // $('.qty').on("input", function() {
        //     var qty = $('#qty').val();
        //     var qty = qty.replace(/[^\d]/g, "");
        //     $('#qty').val(formatAngka(qty * 1));
        // });

    });
</script>