<?php
$total = 0;
foreach ($data->result() as $d) {
    $subtotal = $d->harga_jual * $d->qty;
    $total += $subtotal;
?>
    <tr>
        <td><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->satuan; ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td align="right"><?php echo number_format($d->harga_jual); ?></td>
        <td align="center"><?php echo number_format($d->qty); ?></td>
        <td align="right"><?php echo number_format($subtotal); ?></td>
        <td align="center">
            <a class="btn btn-sm btn-danger hapus" href="#" data-kode="<?php echo $d->kode_barang; ?>"><i class="fa fa-trash"></i></a>
            <a class="btn btn-warning btn-sm edit" href="#" data-stok="<?php echo $d->stok; ?>" data-kode="<?php echo $d->kode_barang; ?>" data-nama="<?php echo $d->nama_barang; ?>" data-ket="<?php echo $d->keterangan; ?>" data-satuan="<?php echo $d->satuan; ?>" data-harga="<?php echo $d->harga_jual; ?>" data-qty="<?php echo $d->qty; ?>"><i class="mdi mdi-pencil"></i></a>
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

        function view_salesorderdetail() {
            var no_so = $('#no_so').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>salesorder/view_salesorder_detail',
                data: {
                    no_so: no_so
                },
                cache: false,
                success: function(respond) {
                    $("#loadsalesorderdetail").html(respond);
                }
            });
        }

        $('.hapus').click(function(e) {
            e.preventDefault();
            var no_so = $('#no_so').val();
            var kode_barang = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>salesorder/hapus_salesorder_detail',
                data: {
                    kode_barang: kode_barang,
                    no_so: no_so
                },
                cache: false,
                success: function(respond) {
                    view_salesorderdetail();
                }
            });
        });

        $('.edit').click(function(e) {
            e.preventDefault();
            var kode_barang = $(this).attr('data-kode');
            var nama_barang = $(this).attr('data-nama');
            var qty = $(this).attr('data-qty');
            var satuan = $(this).attr('data-satuan');
            var harga_jual = $(this).attr('data-harga');
            var ket = $(this).attr('data-ket');
            var stok = $(this).attr('data-stok');
            $('#ket').val(ket);
            $('#nama_barang').val(nama_barang);
            $('#kode_edit').val(1);
            $('#satuan').val(satuan);
            $('#stok').val(stok);
            $('#qty').val(formatAngka(qty));
            $('#harga_jual').val(formatAngka(harga_jual));
            $('#total').val(formatAngka(harga_jual * qty));
            $('#kode_barang').val(kode_barang);

        });


    });
</script>