<?php
$total = 0;
foreach ($data->result() as $d) {
    $subtotal = $d->harga * $d->qty;
    $total += $subtotal;
?>
    <tr>
        <td><?php echo $d->nama_barang; ?></td>
        <td align="right"><?php echo number_format($d->harga) . " @ " . $d->qty; ?></td>
        <td align="right"><?php echo $this->session->userdata('bayar'); ?></td>
        <td align="center">
            <a class="btn btn-sm btn-primary hapus" href="#" data-kode="<?php echo $d->kode_barang; ?>"><i class="fa fa-minus"></i></a>
        </td>
    </tr>
<?php } ?>

<tr>
    <th style="text-align: center;" colspan="4">PEMBAYARAN</th>
</tr>
<tr>
    <th colspan="1">Total Bayar</th>
    <th colspan="3">
        <input class="form-control form-control-sm" readonly id="total" name="total" value="<?php echo number_format($total); ?>" style="text-align: right;" placeholder="Jumlah Bayar">
    </th>
</tr>
<tr>
    <th colspan="1">Potongan</th>
    <th colspan="3">
        <input class="form-control form-control-sm" value="0" id="potongan" name="potongan" style="text-align: right;" placeholder="Potongan">
    </th>
</tr>
<?php if ($this->session->userdata('bayar') == "Sekarang") { ?>
    <tr>
        <th colspan="1">Jumlah Bayar</th>
        <th colspan="3">
            <input class="form-control form-control-sm" value="0" id="jmlbayar" name="jmlbayar" style="text-align: right;" placeholder="Jumlah Bayar">
        </th>
    </tr>
    <tr>
        <th colspan="1">Sisa Bayar</th>
        <th colspan="3">
            <input class="form-control form-control-sm" value="0" readonly id="sisabayar" name="sisabayar" style="text-align: right;" placeholder="Sisa Bayar">
        </th>
    </tr>
    <tr>
        <th colspan="1">Kembalian</th>
        <th colspan="3">
            <input class="form-control form-control-sm" value="0" readonly id="kembalian" name="kembalian" style="text-align: right;" placeholder="Kembalian">
        </th>
    </tr>
<?php } ?>
<tr>
    <th colspan="1">Keterangan</th>
    <th colspan="3">
        <input class="form-control form-control-sm" id="keterangan" name="keterangan" placeholder="Keterangan">
    </th>
</tr>
<tr>
    <th colspan="1">Konfiramsi Pembayaran</th>
    <th style="text-align: right;" colspan="3">
        <a class="btn btn-sm btn-primary" href="#" id="inputpenjualan"><i class="fa  fa-shopping-cart"></i> Bayar</a>
    </th>
</tr>
<script>
    $(document).ready(function() {

        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }

        $('#potongan,#jmlbayar').on("input", function() {

            var potongan = $('#potongan').val();
            var jmlbayar = $('#jmlbayar').val();
            var total = $('#total').val();
            var sisabayar = $('#sisabayar').val();

            var sisabayar = sisabayar.replace(/[^\d]/g, "");
            var total = total.replace(/[^\d]/g, "");
            var potongan = potongan.replace(/[^\d]/g, "");
            var jmlbayar = jmlbayar.replace(/[^\d]/g, "");


            $('#potongan').val(formatAngka(potongan * 1));
            $('#jmlbayar').val(formatAngka(jmlbayar * 1));

            var sisabayar = total - potongan - jmlbayar;
            if (sisabayar < 1) {
                var sisabayar = 0;
            } else {
                var sisabayar = total - potongan - jmlbayar;
            }

            var kembalian = jmlbayar - (total - potongan);
            if (kembalian < 1) {
                var kembalian = 0;
            } else {
                var kembalian = jmlbayar - (total - potongan);
            }

            potonganlebih = total - potongan;
            if (potonganlebih < 0) {
                Swal.fire('Oppss..', 'Potongan Melebihi Total', 'warning')
                $('#sisabayar').val(formatAngka(total));
                $('#potongan').val(0);
                $('#kembalian').val(0);
                $('#jmlbayar').val(0);
            } else {
                $('#sisabayar').val(formatAngka(sisabayar));
                $('#kembalian').val(formatAngka(kembalian));
            }


        });

        function view_penjualantemp() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/view_penjualan_temp',
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
                url: '<?php echo base_url(); ?>penjualan/hapus_penjualan_temp',
                data: {
                    kode_barang: kode_barang
                },
                cache: false,
                success: function(respond) {
                    view_penjualantemp();
                }
            });
        });

        $('#inputpenjualan').click(function(e) {
            e.preventDefault();
            var keterangan = $('#keterangan').val();
            var total = $('#total').val();
            var jmlbayar = $('#jmlbayar').val();
            var potongan = $('#potongan').val();
            var kembalian = $('#kembalian').val();
            if (total == "0") {
                Swal.fire('Oppss..', 'Silahkan Pilih Menu terlebih dahulu', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>penjualan/insert_penjualan',
                    data: {
                        keterangan: keterangan,
                        potongan: potongan,
                        total: total,
                        kembalian: kembalian,
                        jmlbayar: jmlbayar
                    },
                    cache: false,
                    success: function(respond) {
                        location.reload();
                    }
                });
            }
        });

    });
</script>