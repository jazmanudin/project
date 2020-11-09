<?php
foreach ($data->result() as $d) {
?>
    <tr>
        <td><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->satuan; ?></td>
        <td align="right"><?php echo number_format($d->qty); ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td align="center">
            <a class="btn btn-sm btn-danger hapus" href="#" data-kode="<?php echo $d->kode_barang; ?>"><i class="fa fa-trash"></i></a>
        </td>
    </tr>
<?php } ?>
<script>
    $(document).ready(function() {

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