<div class="table-rep-plugin">
    <div class="table-responsive mb-0">
        <table id="datatable" class="table table-bordered dt-responsive nowrap table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead style="background-color: #0085cd;color:white">
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan Barang</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang as $d) {
                ?>
                    <tr>
                        <td><?php echo $d->kode_barang; ?></td>
                        <td><?php echo $d->nama_barang; ?></td>
                        <td><?php echo $d->satuan; ?></td>
                        <td><?php echo number_format($d->harga_modal); ?></td>
                        <td>
                            <a class="btn btn-info btn-sm pilihbarang" href="#" data-kode="<?php echo $d->kode_barang; ?>" data-nama="<?php echo $d->nama_barang; ?>" data-harga="<?php echo $d->harga_modal; ?>" data-satuan="<?php echo $d->satuan; ?>">Pilih</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).ready(function() {
            $('#datatable').dataTable({
                bFilter: false,
                lengthChange: false,
                searching: true,
                paging: true,
                info: false
            });

            function formatAngka(angka) {
                if (typeof(angka) != 'string') angka = angka.toString();
                var reg = new RegExp('([0-9]+)([0-9]{3})');
                while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
                return angka;
            }


            $('.pilihbarang').click(function(e) {
                e.preventDefault();
                var kode_barang = $(this).attr('data-kode');
                var nama_barang = $(this).attr('data-nama');
                var satuan = $(this).attr('data-satuan');
                var harga_modal = $(this).attr('data-harga');

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pembelian/cekbarang',
                    data: {
                        kode_barang: kode_barang
                    },
                    cache: false,
                    success: function(respond) {
                        $("#cekbarang").val(respond);
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pembelian/view_barang',
                    data: '',
                    cache: false,
                    success: function(respond) {
                        $("#loadbarang").html(respond);
                        $("#kode_barang").val(kode_barang);
                        $("#nama_barang").val(nama_barang);
                        $("#satuan").val(satuan);
                        $("#harga_modal").val(formatAngka(harga_modal));
                        $("#viewbarang").modal("hide");
                        $("#ket").focus();
                    }
                });
            });

        });
    });
</script>