<?php
$total = 0;
foreach ($data->result() as $d) {
    $subtotal = $d->harga_modal * $d->qty;
    $total += $subtotal;
?>
    <tr>
        <td><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->satuan; ?></td>
        <td align="right"><?php echo number_format($d->harga_modal); ?></td>
        <td align="right"><?php echo number_format($d->qty); ?></td>
        <td align="right"><?php echo number_format($d->diskon); ?></td>
        <td align="right"><?php echo number_format($subtotal); ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td align="center">
            <a class="btn btn-sm btn-danger hapus" href="#" data-kode="<?php echo $d->kode_barang; ?>"><i class="fa fa-trash"></i></a>
        </td>
    </tr>
<?php } ?>
<tr>
    <th colspan="7">Total</th>
    <th id="totals" style="text-align: right;"><?php echo number_format($total); ?></th>
    <th></th>
</tr>
<script>
    $(document).ready(function() {

        var totals = $('#totals').text();
        $('#subtotal').val(totals);

        function view_pembeliantemp() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/view_pembelian_temp',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#loadpembeliantemp").html(respond);
                }
            });
        }

        $('.hapus').click(function(e) {
            e.preventDefault();
            var kode_barang = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/hapus_pembelian_temp',
                data: {
                    kode_barang: kode_barang
                },
                cache: false,
                success: function(respond) {
                    view_pembeliantemp();
                }
            });
        });

    });
</script>