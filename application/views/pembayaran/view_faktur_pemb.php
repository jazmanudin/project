<div class="table-rep-plugin">
    <div class="table-responsive mb-0">
        <table id="datatable" class="table table-bordered dt-responsive nowrap table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead style="background-color: #0085cd;color:white">
                <tr>
                    <th>No Faktur</th>
                    <th>Nama Supplier</th>
                    <th style="text-align: right;">Total</th>
                    <th style="text-align: right;">Potongan</th>
                    <th style="text-align: right;">Bayar</th>
                    <th style="text-align: right;">Sisa Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($faktur as $d) {
                    $subtotal = $d->total - $d->potongan;
                    if ($subtotal - $d->jumlahbayar > 0) {
                ?>
                        <tr>
                            <td><?php echo $d->no_fak_pemb; ?></td>
                            <td><?php echo $d->nama_supplier; ?></td>
                            <td align="right"><?php echo number_format($d->total); ?></td>
                            <td align="right"><?php echo number_format($subtotal); ?></td>
                            <td align="right"><?php echo number_format($d->jumlahbayar); ?></td>
                            <td align="right"><?php echo number_format($subtotal - $d->jumlahbayar); ?></td>
                            <td>
                                <a class="btn btn-info btn-sm pilihfaktur" href="#" data-supp="<?php echo $d->kode_supplier; ?>" data-sisa="<?php echo $subtotal - $d->jumlahbayar; ?>" data-bayar="<?php echo $d->jumlahbayar; ?>" data-subtotal="<?php echo $subtotal; ?>" data-kode="<?php echo $d->no_fak_pemb; ?>">Pilih</a>
                            </td>
                        </tr>
                <?php }
                } ?>
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


            $('.pilihfaktur').click(function(e) {
                e.preventDefault();
                var no_fak_pemb = $(this).attr('data-kode');
                var kode_supplier = $(this).attr('data-supp');
                var subtotal = $(this).attr('data-subtotal');
                var bayar = $(this).attr('data-bayar');
                var sisa_bayar = $(this).attr('data-sisa');

                // $.ajax({
                //     type: 'POST',
                //     url: '<?php echo base_url(); ?>pembelian/cekbarang',
                //     data: {
                //         no_fak_pemb: no_fak_pemb
                //     },
                //     cache: false,
                //     success: function(respond) {
                //         $("#cekbarang").val(respond);
                //     }
                // });

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pembayaran/view_faktur_pemb',
                    data: {
                        kode_supplier: kode_supplier
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadfaktur").html(respond);
                        $("#no_fak_pemb").val(no_fak_pemb);
                        $("#total").val(formatAngka(subtotal));
                        $("#bayar").val(formatAngka(bayar*1));
                        $("#sisa_bayar").val(formatAngka(sisa_bayar));
                        $("#jumlah_bayar").val(formatAngka(sisa_bayar));
                        $("#viewfaktur").modal("hide");
                        $("#jumlah_bayar").focus();
                    }
                });
            });

        });
    });
</script>