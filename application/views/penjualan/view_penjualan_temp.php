<?php
$total = 0;
foreach ($data->result() as $d) {
    $subtotal = $d->harga * $d->qty;
    $total += $subtotal;
?>
    <tr>
        <td><?php echo $d->nama_barang; ?></td>
        <td align="right"><?php echo number_format($d->harga) . " @ " . $d->qty; ?></td>
        <td align="right"><?php echo number_format($subtotal); ?></td>
        <td align="center">
            <a class="btn btn-sm btn-primary hapus" href="#" data-kode="<?php echo $d->kode_barang; ?>"><i class="fa fa-minus"></i></a>
        </td>
    </tr>
<?php } ?>

<tr>
    <th colspan="1">Total</th>
    <th colspan="3">
        <input class="form-control form-control-sm" readonly id="total" name="total" value="<?php echo number_format($total); ?>" style="text-align: right;" placeholder="Jumlah Bayar">
    </th>
</tr>
<tr>
    <th colspan="1">Bayar</th>
    <th colspan="3">
        <input class="form-control form-control-sm" id="jmlbayar" name="jmlbayar" style="text-align: right;" placeholder="Jumlah Bayar">
    </th>
</tr>
<tr>
    <th colspan="1">Potongan</th>
    <th colspan="3">
        <input class="form-control form-control-sm" id="potongan" name="potongan" style="text-align: right;" placeholder="Potongan">
    </th>
</tr>
<tr>
    <th colspan="1">Subtotal</th>
    <th colspan="3">
        <input class="form-control form-control-sm" readonly id="subtotal" name="subtotal" style="text-align: right;" placeholder="Jumlah Bayar">
    </th>
</tr>
<tr>
    <th colspan="1">Keterangan</th>
    <th colspan="3">
        <input class="form-control form-control-sm" id="keterangan" name="keterangan" placeholder="Keterangan">
    </th>
</tr>
<tr>
    <th colspan="1">Konfiramsi Pembayaran</th>
    <th style="text-align: right;" colspan="3">
        <a class="btn btn-sm btn-primary" href="#" id="inputpenjualan"><i class="fa  fa-shopping-cart"></i> Bayar</a>
    </th>
</tr>
<script>
    $(document).ready(function() {

        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }

        var total = $('#total').val();
        var total = total.replace(/[^\d]/g, "");
        $('#subtotal').val(formatAngka(total * 1));

        $('#potongan').on("input", function() {

            var potongan = $('#potongan').val();
            var total = $('#total').text();

            var potongan = potongan.replace(/[^\d]/g, "");
            var total = total.replace(/[^\d]/g, "");


            $('#potongan').val(formatAngka(potongan * 1));
            var subtotal = total - potongan;
            if (subtotal < 0) {
                alert("Potongan Melebihi Total");
                $('#potongan').val("");
                $('#subtotal').text(formatAngka(total));
            }else{
                $('#subtotal').text(formatAngka(subtotal));
            }


        });

        function view_penjualantemp() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/view_penjualan_temp',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#loadpenjualantemp").html(respond);
                }
            });
        }

        $('.hapus').click(function(e) {
            e.preventDefault();
            var kode_barang = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/hapus_penjualan_temp',
                data: {
                    kode_barang: kode_barang
                },
                cache: false,
                success: function(respond) {
                    view_penjualantemp();
                }
            });
        });

        $('#inputpenjualan').click(function(e) {
            e.preventDefault();
            var keterangan = $('#keterangan').val();
            var jmlbayar = $('#jmlbayar').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/insert_penjualaan',
                data: {
                    keterangan: keterangan,
                    jmlbayar: jmlbayar
                },
                cache: false,
                success: function(respond) {
                    location.reload();
                }
            });
        });
    });
</script>