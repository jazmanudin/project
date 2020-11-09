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
        <td><?php echo $d->keterangan; ?></td>
        <td><?php echo $d->exp_date; ?></td>
        <td align="right"><?php echo number_format($d->harga_modal); ?></td>
        <td align="center"><?php echo number_format($d->qty); ?></td>
        <td align="right"><?php echo number_format($subtotal); ?></td>
        <td align="center">
            <a class="btn btn-sm btn-danger hapus" href="#" data-kode="<?php echo $d->kode_barang; ?>"><i class="fa fa-trash"></i></a>
            <a class="btn btn-sm btn-warning edit" href="#" data-exp="<?php echo $d->exp_date; ?>" data-qty="<?php echo $d->qty; ?>" data-harga="<?php echo $d->harga_modal; ?>" data-ket="<?php echo $d->keterangan; ?>" data-satuan="<?php echo $d->satuan; ?>" data-nama="<?php echo $d->nama_barang; ?>" data-kode="<?php echo $d->kode_barang; ?>"><i class="mdi mdi-pencil"></i></a>
        </td>
    </tr>
<?php } ?>
<tr>
    <th style="text-align: center;" colspan="6">Total</th>
    <th id="totals" style="text-align: right;"><?php echo number_format($total); ?></th>
    <th></th>
</tr>
<script>
    $(document).ready(function() {

        var totals = $('#totals').text();
        $('#subtotal').val(totals);


        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }


        function view_pembeliandetail() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/view_pembelian_temp',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#loadpembeliandetail").html(respond);
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
                    view_pembeliandetail();
                }
            });
        });

        $('.edit').click(function(e) {
            e.preventDefault();
            var kode_barang = $(this).attr('data-kode');
            var nama_barang = $(this).attr('data-nama');
            var exp_date = $(this).attr('data-exp');
            var qty = $(this).attr('data-qty');
            var satuan = $(this).attr('data-satuan');
            var harga_modal = $(this).attr('data-harga');
            var keterangan = $(this).attr('data-ket');

            $('#kode_barang').val(kode_barang);
            $('#exp_date').val(exp_date);
            $('#nama_barang').val(nama_barang);
            $('#qty').val(formatAngka(qty));
            $('#satuan').val(satuan);
            $('#harga_modal').val(formatAngka(harga_modal));
            $('#total').val(formatAngka(harga_modal * qty));
            $('#keterangan').val(keterangan);
            $('#kode_edit').val(1);

        });

    });
</script>