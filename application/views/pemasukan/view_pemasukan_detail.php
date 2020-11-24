<?php
foreach ($data->result() as $d) {
?>
    <tr>
        <td><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->satuan; ?></td>
        <td><?php echo $d->exp_date; ?></td>
        <td align="right"><?php echo number_format($d->qty); ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td align="center">
            <a class="btn btn-sm btn-danger hapus" href="#" data-kode="<?php echo $d->kode_barang; ?>"><i class="fa fa-trash"></i></a>
            <a class="btn btn-sm btn-warning edit" href="#" data-exp="<?php echo $d->exp_date; ?>" data-qty="<?php echo $d->qty; ?>" data-ket="<?php echo $d->keterangan; ?>" data-satuan="<?php echo $d->satuan; ?>" data-nama="<?php echo $d->nama_barang; ?>" data-kode="<?php echo $d->kode_barang; ?>"><i class="mdi mdi-pencil"></i></a>
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

        function view_pemasukandetail() {

            var no_pemasukan = $('#no_pemasukan').val();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pemasukan/view_pemasukan_detail',
                data: {
                    no_pemasukan: no_pemasukan
                },
                cache: false,
                success: function(respond) {
                    $("#loadpemasukandetail").html(respond);
                }
            });
        }

        $('.hapus').click(function(e) {
            e.preventDefault();
            var no_pemasukan = $('#no_pemasukan').val();
            var kode_barang = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pemasukan/hapus_pemasukan_detail',
                data: {
                    kode_barang: kode_barang,
                    no_pemasukan: no_pemasukan
                },
                cache: false,
                success: function(respond) {
                    view_pemasukandetail();
                    $('#ket').val("");
                    $('#exp_date').val("");
                    $('#kode_barang').val("");
                    $('#nama_barang').val("");
                    $('#satuan').val("");
                    $('#qty').val("");
                }
            });
        });

        $('.edit').click(function(e) {
            e.preventDefault();
            var kode_barang = $(this).attr('data-kode');
            var exp_date = $(this).attr('data-exp');
            var nama_barang = $(this).attr('data-nama');
            var qty = $(this).attr('data-qty');
            var satuan = $(this).attr('data-satuan');
            var keterangan = $(this).attr('data-ket');

            $('#kode_barang').val(kode_barang);
            $('#exp_date').val(exp_date);
            $('#nama_barang').val(nama_barang);
            $('#satuan').val(satuan);
            $('#qty').val(formatAngka(qty));
            $('#ket').val(keterangan);
            $('#kode_edit').val(1);
            $('#qty').focus();

        });

    });
</script>