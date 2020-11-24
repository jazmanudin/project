<?php
$total = 0;
foreach ($data->result() as $d) {
    $total += $d->jumlah;
    $subtotal = $d->total - $d->potongan;

?>
    <tr>
        <td><?php echo $d->no_fak_pemb; ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td align="right"><?php echo number_format($d->jumlah); ?></td>
        <td align="center">
            <a class="btn btn-sm btn-warning edit" href="#" data-potongan="<?php echo $d->potongan; ?>" data-bayar="<?php echo $d->jumlahbayar; ?>" data-total="<?php echo $subtotal; ?>" data-ket="<?php echo $d->keterangan; ?>" data-jumlah="<?php echo $d->jumlah; ?>" data-kode="<?php echo $d->no_fak_pemb; ?>"><i class="mdi mdi-pencil"></i></a>
        </td>
    </tr>
<?php } ?>
<tr>
    <th style="text-align: center;" colspan="2">Total</th>
    <th id="totals" style="text-align: right;"><?php echo number_format($total); ?></th>
    <th></th>
</tr>
<script>
    $(document).ready(function() {

        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }

        function view_pembayarandeatil() {
            var nobukti = $('#nobukti').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembayaran/view_pembayaran_hutang_detail',
                data: {
                    nobukti: nobukti
                },
                cache: false,
                success: function(respond) {
                    $("#loadpembayarandetail").html(respond);
                }
            });
        }

        $('.edit').click(function(e) {
            e.preventDefault();
            var no_fak_pemb = $(this).attr('data-kode');
            var jumlah_bayar = $(this).attr('data-jumlah');
            var bayar = $(this).attr('data-bayar');
            var keterangan = $(this).attr('data-ket');
            var total = $(this).attr('data-total');
            var potongan = $(this).attr('data-potongan');
            var bayarhutang = bayar - jumlah_bayar;

            $('#no_fak_pemb').val(no_fak_pemb);
            $('#bayar').val(formatAngka(bayarhutang));
            $('#jumlah_bayar').val(formatAngka(jumlah_bayar));
            $('#sisa_bayar').val(formatAngka(total - bayarhutang));
            $('#total').val(formatAngka(total));
            $('#potongan').val(formatAngka(potongan));
            $('#keterangan').val(keterangan);
            $('#kode_edit').val(1);
            $('#jumlah_bayar').focus();

        });

    });
</script>