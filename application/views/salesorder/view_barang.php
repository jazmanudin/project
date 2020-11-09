<div class="table-rep-plugin">
    <div class="table-responsive mb-0">
        <table id="datatable" class="table table-bordered dt-responsive nowrap table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead style="background-color: #0085cd;color:white">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Satuan</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Exp Date</th>
                    <!-- <th style="text-align: right;">Harga</th> -->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang->result() as $d) {
                ?>
                    <tr>
                        <td><?php echo $d->kode_barang; ?></td>
                        <td><?php echo $d->nama_barang; ?></td>
                        <td><?php echo $d->satuan; ?></td>
                        <td><?php echo $d->nama_kategori; ?></td>
                        <td><?php echo $d->stok; ?></td>
                        <td><?php echo $d->exp_date; ?></td>
                        <!-- <td align="right"><?php echo number_format($d->harga_tetap); ?></td> -->
                        <td>
                            <a class="btn btn-info btn-sm pilihbarang" href="#" data-stoks="<?php echo $d->stoks; ?>" data-stok="<?php echo $d->stok; ?>" data-kode="<?php echo $d->kode_barang; ?>" data-tetap="<?php echo $d->pelanggan_tetap; ?>" data-grosir="<?php echo $d->grosir; ?>" data-eceran="<?php echo $d->eceran; ?>" data-lainnya="<?php echo $d->lainnya; ?>" data-tidaktetap="<?php echo $d->tidak_tetap; ?>" data-nama="<?php echo $d->nama_barang; ?>" data-satuan="<?php echo $d->satuan; ?>">Pilih</a>
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
                var tetap = $(this).attr('data-tetap');
                var tidaktetap = $(this).attr('data-tidaktetap');
                var grosir = $(this).attr('data-grosir');
                var eceran = $(this).attr('data-eceran');
                var lainnya = $(this).attr('data-lainnya');
                var harga = $(this).attr('data-harga');
                var stoks = $(this).attr('data-stoks');
                var stok = $(this).attr('data-stok');
                var jenis_harga = $('#jenis_harga').val();

                stokakhir = stoks - stok;
                if (stokakhir > 0) {
                    Swal.fire('Oppss..', 'Barang ada yang Exp, silahkan untuk buang terlebih dahulu..!!', 'warning')
                } else {

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>salesorder/cekbarang',
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
                        url: '<?php echo base_url(); ?>salesorder/view_barang',
                        data: '',
                        cache: false,
                        success: function(respond) {
                            $("#loadbarang").html(respond);
                            $("#kode_barang").val(kode_barang);
                            $("#nama_barang").val(nama_barang);
                            $("#stok").val(stok);
                            $("#satuan").val(satuan);
                            // $("#harga_jual").val(jenis_harga);

                            if (jenis_harga == "Pelanggan Tetap") {
                                $("#harga_jual").val(formatAngka(tetap));
                            } else if (jenis_harga == "Tidak Tetap") {
                                $("#harga_jual").val(formatAngka(tidaktetap));
                            } else if (jenis_harga == "Grosir") {
                                $("#harga_jual").val(formatAngka(grosir));
                            } else if (jenis_harga == "Eceran") {
                                $("#harga_jual").val(formatAngka(eceran));
                            } else if (jenis_harga == "Lainnya") {
                                $("#harga_jual").val(formatAngka(lainnya));
                            }

                            $("#viewbarang").modal("hide");
                            $("#ket").focus();
                        }
                    });
                }
            });

        });
    });
</script>