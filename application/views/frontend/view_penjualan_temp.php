<?php
$total = 0;
foreach ($data->result() as $d) {
    $subtotal = $d->harga * $d->qty;
    $total += $subtotal;
?>
    <tr>
        <td><?php echo $d->nama_barang; ?></td>
        <td align="right"><?php echo number_format($d->harga)." @ ".$d->qty; ?></td>
        <td align="right"><?php echo number_format($subtotal); ?></td>
        <td align="center">
            <a class="btn btn-sm btn-danger hapus" href="#" data-kode="<?php echo $d->kode_barang; ?>"><i class="fa fa-trash"></i></a>
        </td>
    </tr>
<?php } ?>
<tr>
    <th colspan="2">Total</th>
    <th style="text-align: right;"><?php echo number_format($total, 2); ?></th>
    <th></th>
</tr>
<tr>
    <th colspan="2">Potongan</th>
    <th style="text-align: right;" colspan="2">
    <input class="form-control form-control-sm" id="potongan" name="potongan" style="text-align: right;" placeholder="Potongan">
    </th>
</tr>
<tr>
    <th colspan="2">Pembayaran</th>
    <th style="text-align: right;" colspan="2">
        <a class="btn btn-sm btn-primary" href="#"><i class="fa  fa-shopping-cart"></i></a>
    </th>
</tr>

<script>
    $(document).ready(function() {

        function view_penjualantemp() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>frontend/view_penjualan_temp',
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
                url: '<?php echo base_url(); ?>frontend/hapus_temp',
                data: {
                    kode_barang: kode_barang
                },
                cache: false,
                success: function(respond) {
                    view_penjualantemp();
                }
            });
        });
    });
</script>