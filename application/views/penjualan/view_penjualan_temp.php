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
            <a class="btn btn-warning btn-sm edit" href="#" data-stok="<?php echo $d->stok; ?>" data-kode="<?php echo $d->kode_barang; ?>" data-nama="<?php echo $d->nama_barang; ?>" data-ket="<?php echo $d->keterangan; ?>" data-satuan="<?php echo $d->satuan; ?>" data-hargamodal="<?php echo $d->harga_modal; ?>" data-exp_date="<?php echo $d->exp_date; ?>" data-barangke="<?php echo $d->barangke; ?>" data-harga="<?php echo $d->harga_jual; ?>" data-qty="<?php echo $d->qty; ?>"><i class="mdi mdi-pencil"></i></a>
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
        $('#totalkeranjang').html("Rp. " + totals);

        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }

        function view_penjualantemp() {
            var no_fak_penj = $('#no_fak_penj').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/view_penjualan_temp',
                data: {
                    no_fak_penj: no_fak_penj
                },
                cache: false,
                success: function(respond) {
                    $("#loadpenjualantemp").html(respond);
                }
            });

            $('#nama_pelanggan').autocomplete({
                serviceUrl: "<?php echo base_url(); ?>penjualan/get_pelanggan/",
                onSelect: function(suggestions) {
                    $('#nama_pelanggan').val(suggestions.nama_pelanggan);
                    $('#kode_pelanggan').val(suggestions.kode_pelanggan);
                    $('#id_sales').val(suggestions.id_sales);
                    $('#nama_sales').val(suggestions.nama_karyawan);
                    $('#jatuh_tempo').val(suggestions.jatuh_tempo);
                    $('#jenis_harga').val(suggestions.jenis_harga);
                    var jenis_harga = suggestions.jenis_harga;

                    $('#kode_barang').autocomplete({
                        serviceUrl: "<?php echo base_url(); ?>penjualan/get_barang/",
                        onSelect: function(suggestions) {
                            stokakhir = suggestions.stoks - suggestions.stok;
                            if (stokakhir > 0) {
                                Swal.fire('Oppss..', 'Barang ada yang Exp, silahkan untuk buang terlebih dahulu..!!', 'warning')
                            } else {
                                $('#nama_barang').val(suggestions.nama_barang);
                                $('#kode_barang').val(suggestions.kode_barang);
                                $('#satuan').val(suggestions.satuan);
                                $('#exp_date').val(suggestions.exp_date);
                                $('#barangke').val(suggestions.barangke);
                                $("#stok").val(formatAngka(suggestions.stok));
                                $("#harga_modal").val(formatAngka(suggestions.harga_modal));
                                view_penjualantemp();

                                if (jenis_harga == "Pelanggan Tetap") {
                                    $("#harga_jual").val(formatAngka(suggestions.pelanggan_tetap));
                                } else if (jenis_harga == "Tidak Tetap") {
                                    $("#harga_jual").val(formatAngka(suggestions.tidak_tetap));
                                } else if (jenis_harga == "Grosir") {
                                    $("#harga_jual").val(formatAngka(suggestions.grosir));
                                } else if (jenis_harga == "Eceran") {
                                    $("#harga_jual").val(formatAngka(suggestions.eceran));
                                } else if (jenis_harga == "Lainnya") {
                                    $("#harga_jual").val(formatAngka(suggestions.lainnya));
                                }

                            }
                        }
                    });

                    $('#nama_barang').autocomplete({
                        serviceUrl: "<?php echo base_url(); ?>penjualan/get_barang2/",
                        onSelect: function(suggestions) {
                            stokakhir = suggestions.stoks - suggestions.stok;
                            if (stokakhir > 0) {
                                Swal.fire('Oppss..', 'Barang ada yang Exp, silahkan untuk buang terlebih dahulu..!!', 'warning')
                            } else {
                                $('#nama_barang').val(suggestions.nama_barang);
                                $('#kode_barang').val(suggestions.kode_barang);
                                $('#satuan').val(suggestions.satuan);
                                $('#exp_date').val(suggestions.exp_date);
                                $('#barangke').val(suggestions.barangke);
                                $("#stok").val(formatAngka(suggestions.stok));
                                $("#harga_modal").val(formatAngka(suggestions.harga_modal));
                                view_penjualantemp();

                                if (jenis_harga == "Pelanggan Tetap") {
                                    $("#harga_jual").val(formatAngka(suggestions.pelanggan_tetap));
                                } else if (jenis_harga == "Tidak Tetap") {
                                    $("#harga_jual").val(formatAngka(suggestions.tidak_tetap));
                                } else if (jenis_harga == "Grosir") {
                                    $("#harga_jual").val(formatAngka(suggestions.grosir));
                                } else if (jenis_harga == "Eceran") {
                                    $("#harga_jual").val(formatAngka(suggestions.eceran));
                                } else if (jenis_harga == "Lainnya") {
                                    $("#harga_jual").val(formatAngka(suggestions.lainnya));
                                }

                            }
                        }
                    });

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
                    $('#ket').val("");
                    $('#kode_barang').val("");
                    $('#kode_edit').val(0);
                    $('#cekbarang').val(0);
                    $('#exp_date').val("");
                    $('#harga_modal').val("");
                    $('#barangke').val("");
                    $('#stok').val("");
                    $('#satuan').val("");
                    $('#nama_barang').val("");
                    $('#qty').val("");
                    $('#harga_jual').val("");
                    $('#total').val("");
                    $('#nama_barang').focus();
                }
            });
        });

        $('.edit').click(function(e) {
            e.preventDefault();
            var kode_barang = $(this).attr('data-kode');
            var nama_barang = $(this).attr('data-nama');
            var qty = $(this).attr('data-qty');
            var satuan = $(this).attr('data-satuan');
            var exp_date = $(this).attr('data-exp_date');
            var barangke = $(this).attr('data-barangke');
            var hargamodal = $(this).attr('data-hargamodal');
            var stok = $(this).attr('data-stok');
            var harga_jual = $(this).attr('data-harga');
            var ket = $(this).attr('data-ket');
            $('#ket').val(ket);
            $('#nama_barang').val(nama_barang);
            $('#kode_edit').val(1);
            $('#exp_date').val(exp_date);
            $('#barangke').val(barangke);
            $('#harga_modal').val(hargamodal);
            $('#satuan').val(satuan);
            $('#stok').val(stok);
            $('#qty').val(formatAngka(qty));
            $('#harga_jual').val(formatAngka(harga_jual));
            $('#total').val(formatAngka(harga_jual * qty));
            $('#kode_barang').val(kode_barang);
            $('#qty').focus();
        });

    });
</script>