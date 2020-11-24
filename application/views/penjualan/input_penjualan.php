<style>
    div.scrolled {
        width: 100%;
        height: 450px;
        overflow: auto;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>INPUT PENJUALAN</b></h5>
    </div>
</div>

<?php
if ($this->uri->segment(3) != "") {
    $jenis_harga      = $salesorder['jenis_harga'];
    $nama_pelanggan   = $salesorder['nama_pelanggan'];
    $kode_pelanggan   = $salesorder['kode_pelanggan'];
    $id_sales         = $salesorder['id_sales'];
    $nama_sales       = $salesorder['nama_karyawan'];
    $jatuhtempo       = $salesorder['jatuh_tempo'];
    $ppn              = $this->uri->segment(5);
    $no_so            = $this->uri->segment(3);
} else {
    $jenis_harga      = "";
    $nama_pelanggan   = "";
    $kode_pelanggan   = "";
    $nama_sales       = "";
    $id_sales         = "";
    $no_so            = "-";
    $jatuhtempo       = "";
    $ppn              = "";
}
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="no_fak_penj" name="no_fak_penj" placeholder="No PO">
                        <input type="hidden" autocomplete="off" name="kode_edit" id="kode_edit" value="0" class="form-control form-control-sm" />
                        <input type="hidden" autocomplete="off" name="cekbarang" id="cekbarang" value="0" class="form-control form-control-sm" />
                    </div>
                    <div class="col-md-3" style="padding-left:2px;padding-right:0px">
                        <input type="text" autocomplete="off" value="<?php echo $nama_pelanggan; ?>" autofocus name="nama_pelanggan" id="nama_pelanggan" class="form-control form-control-sm" placeholder="Nama Pelanggan" tabindex="1" />
                        <input type="hidden" autocomplete="off" name="no_so" id="no_so" value="<?php echo $no_so; ?>" class="form-control form-control-sm" />
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" autocomplete="off" value="<?php echo $kode_pelanggan; ?>" readonly name="kode_pelanggan" id="kode_pelanggan" class="form-control form-control-sm" placeholder="Kode Pelanggan" />
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" autocomplete="off" value="<?php echo $jatuhtempo; ?>" readonly name="jatuh_tempo" id="jatuh_tempo" placeholder="Jatuh Tempo" class="form-control form-control-sm" data-language="en" />
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" readonly autocomplete="off" value="<?php echo $nama_sales; ?>" name="nama_sales" id="nama_sales" class="form-control form-control-sm" placeholder="Nama Sales" />
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" readonly autocomplete="off" value="<?php echo $id_sales; ?>" name="id_sales" id="id_sales" class="form-control form-control-sm" placeholder="ID Sales" />
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" autocomplete="off" readonly value="<?php echo $jenis_harga; ?>" name="jenis_harga" id="jenis_harga" class="form-control form-control-sm" placeholder="Jenis Harga" />
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" autocomplete="off" value="<?php echo Date('Y-m-d'); ?>" name="tgl_transaksi" id="tgl_transaksi" placeholder="Tanggal Transaksi" class="form-control form-control-sm datepicker-here" data-language="en" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" id="nama_barang" name="nama_barang" placeholder="Nama Barang" tabindex="2">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="kode_barang" name="kode_barang" placeholder="Barcode" tabindex="2">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="satuan" name="satuan" placeholder="Satuan">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" readonly class="form-control form-control-sm datepicker-here" autocomplete="off" name="exp_date" id="exp_date" placeholder="Exp Date" data-language="en" />
                    </div>
                    <div class="col-md-1" hidden style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" name="barangke" id="barangke" placeholder="Barang Ke" />
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px" hidden>
                        <input type="text" class="form-control form-control-sm" readonly id="harga_modal" name="harga_modal" placeholder="Harga Modal">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" style="text-align:right" id="harga_jual" name="harga_jual" placeholder="Harga Jual">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly autocomplete="off" id="stok" name="stok" placeholder="Stok">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="qty" name="qty" placeholder="Jumlah" tabindex="3">
                    </div>
                    <div class="col-md-2" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" value="-" id="ket" name="ket" placeholder="Keterangan">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="total" style="text-align:right" name="total" placeholder="Total">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px;color:white">
                        <a class="btn btn-info btn-sm btn-block" id="inputbarang" href="#" tabindex="4"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="padding-left:2px;padding-right:0px">
                        <div class="table-responsive mb-0">
                            <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                                <thead style="background-color: #0085cd;color:white">
                                    <tr>
                                        <th style="width: 5%;">Kode</th>
                                        <th>Nama</th>
                                        <th style="width: 5%;">Satuan</th>
                                        <th>Keterangan</th>
                                        <th style="width: 10%;text-align:right">Harga</th>
                                        <th style="width: 10%;text-align:center">Jumlah</th>
                                        <th style="width: 10%;text-align:right">Total</th>
                                        <th style="width: 5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadpenjualantemp" style="font-size: 13px;">

                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-6 col-sm-12">
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12" id="pembayaran">
        <div class="card">
            <div class="card-body">
                <!-- <h5 style="text-align: center;" colspan="4">PEMBAYARAN</h5> -->
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Subtotal</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" readonly id="subtotal" name="subtotal" style="text-align: right;" placeholder="Subtotal">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Potongan</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" id="potongan" name="potongan" style="text-align: right;" placeholder="Potongan" tabindex="5">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Jumlah Bayar</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" id="jumlah_bayar" name="jumlah_bayar" style="text-align: right;" placeholder="Jumlah Bayar" tabindex="6">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Sisa Bayar</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" readonly id="sisa_bayar" name="sisa_bayar" style="text-align: right;" placeholder="Sisa Bayar">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Kembalian</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" readonly id="kembalian" name="kembalian" style="text-align: right;" placeholder="Kembalian">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Keterangan</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" id="keterangan" name="keterangan" placeholder="Keterangan" tabindex="7">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">PPN</label>
                    <div class="col-sm-8">
                        <select class="form-control form-control-sm" id="ppn" name="ppn" tabindex="8">
                            <option <?php if ($ppn == "No") {
                                        echo "selected";
                                    } ?> value="No">No</option>
                            <option <?php if ($ppn == "Yes") {
                                        echo "selected";
                                    } ?> value="Yes">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Konfirmasi</label>
                    <div class="col-md-8">
                        <a class="btn btn-sm btn-primary btn-block" href="#" id="inputpenjualan" tabindex="15"><i class="fa  fa-save"></i> Simpan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }

        view_penjualantemp();

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
                var no_so = $('#no_so').val();

                $('#nama_barang').autocomplete({
                    serviceUrl: "<?php echo base_url(); ?>penjualan/get_barang/" + no_so,
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

        var no_so = $('#no_so').val();
        if (no_so != "-") {
            var jenis_harga = $('#jenis_harga').val();
            $('#nama_barang').autocomplete({
                serviceUrl: "<?php echo base_url(); ?>penjualan/get_barang/" + no_so,
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

        function cekbarang() {

            var kode_barang = $('#kode_barang').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/cekbarang',
                data: {
                    kode_barang: kode_barang
                },
                cache: false,
                success: function(respond) {
                    $("#cekbarang").val(respond);
                }
            });

        }

        function view_penjualantemp() {

            var no_so = $('#no_so').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/view_penjualan_temp',
                data: {
                    no_so: no_so
                },
                cache: false,
                success: function(respond) {
                    $("#loadpenjualantemp").html(respond);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>penjualan/codeotomatis',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#no_fak_penj").val(respond);
                }
            });

        }

        $('#harga_jual').on("input", function() {
            var harga_jual = $('#harga_jual').val();
            var harga_jual = harga_jual.replace(/[^\d]/g, "");
            $('#harga_jual').val(formatAngka(harga_jual * 1));
        });


        $('#qty').on("input", function() {
            var qty = $('#qty').val();
            var qty = qty.replace(/[^\d]/g, "");
            $('#qty').val(formatAngka(qty * 1));
        });

        $('#qty,#harga_jual').on("input", function() {
            var qty = $('#qty').val();
            var stok = $('#stok').val();
            var harga_jual = $('#harga_jual').val();

            var stok = stok.replace(/[^\d]/g, "");
            var qty = qty.replace(/[^\d]/g, "");
            var harga_jual = harga_jual.replace(/[^\d]/g, "");

            var stokakhir = stok - qty;

            if (stokakhir < 0) {
                Swal.fire('Oppss..', 'Qty melebihi Stok', 'warning')
                $('#qty').val(formatAngka(stok));
            }

            var hasiltotal = qty * harga_jual;

            $('#total').val(formatAngka(hasiltotal * 1));
        });

        $('#potongan,#jumlah_bayar').on("input", function() {

            var potongan = $('#potongan').val();
            var jumlah_bayar = $('#jumlah_bayar').val();
            var subtotal = $('#subtotal').val();
            var sisa_bayar = $('#sisa_bayar').val();

            var sisa_bayar = sisa_bayar.replace(/[^\d]/g, "");
            var subtotal = subtotal.replace(/[^\d]/g, "");
            var potongan = potongan.replace(/[^\d]/g, "");
            var jumlah_bayar = jumlah_bayar.replace(/[^\d]/g, "");


            $('#potongan').val(formatAngka(potongan * 1));
            $('#jumlah_bayar').val(formatAngka(jumlah_bayar * 1));

            var sisa_bayar = subtotal - potongan - jumlah_bayar;
            if (sisa_bayar < 1) {
                var sisa_bayar = 0;
            } else {
                var sisa_bayar = subtotal - potongan - jumlah_bayar;
            }

            var kembalian = jumlah_bayar - (subtotal - potongan);
            if (kembalian < 1) {
                var kembalian = 0;
            } else {
                var kembalian = jumlah_bayar - (subtotal - potongan);
            }

            potonganlebih = subtotal - potongan;
            if (potonganlebih < 0) {
                Swal.fire('Oppss..', 'Potongan Melebihi Subtotal', 'warning')
                $('#sisa_bayar').val(formatAngka(subtotal));
                $('#potongan').val(0);
                $('#kembalian').val(0);
                $('#jumlah_bayar').val(0);
            } else {
                $('#sisa_bayar').val(formatAngka(sisa_bayar));
                $('#kembalian').val(formatAngka(kembalian));
            }
        });

        function clear() {
            $('#ket').val("");
            $('#kode_barang').val("");
            $('#cekbarang').val(0);
            $('#kode_edit').val(0);
            $('#exp_date').val("");
            $('#barangke').val("");
            $('#stok').val("");
            $('#satuan').val("");
            $('#nama_barang').val("");
            $('#qty').val("");
            $('#harga_jual').val("");
            $('#harga_modal').val("");
            $('#total').val("");
        }

        $('#inputbarang').click(function(e) {
            e.preventDefault();
            var kode_barang = $('#kode_barang').val();
            var qty = $('#qty').val();
            var harga_jual = $('#harga_jual').val();
            var kode_edit = $('#kode_edit').val();
            var exp_date = $('#exp_date').val();
            var barangke = $('#barangke').val();
            var no_so = $('#no_so').val();
            var keterangan = $('#ket').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            var id_sales = $('#id_sales').val();
            var kode_pelanggan = $('#kode_pelanggan').val();
            var cekbarang = $('#cekbarang').val();

            if (kode_barang == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
                return false;
            } else if (cekbarang > 0) {
                Swal.fire('Oppss..', 'Barang sudah ada', 'warning')
                return false;
            } else if (kode_pelanggan == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Pelanggan terlebih dahulu', 'warning')
                return false;
            } else if (id_sales == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Sales terlebih dahulu', 'warning')
                return false;
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
                return false;
            } else if (qty == "0" || qty == "") {
                Swal.fire('Oppss..', 'Qty tidak boleh kosong', 'warning')
                return false;
            } else if (harga_jual == "") {
                Swal.fire('Oppss..', 'Harga Modal tidak boleh kosong', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>penjualan/insert_penjualan_temp',
                    data: {
                        kode_barang: kode_barang,
                        kode_edit: kode_edit,
                        exp_date: exp_date,
                        barangke: barangke,
                        kode_pelanggan: kode_pelanggan,
                        qty: qty,
                        harga_jual: harga_jual,
                        no_so: no_so,
                        keterangan: keterangan
                    },
                    cache: false,
                    success: function(respond) {
                        view_penjualantemp();
                        $('#ket').val("");
                        $('#kode_barang').val("");
                        $('#kode_edit').val(0);
                        $('#exp_date').val("");
                        $('#barangke').val("");
                        $('#harga_modal').val("");
                        $('#stok').val("");
                        $('#satuan').val("");
                        $('#nama_barang').val("");
                        $('#qty').val("");
                        $('#harga_jual').val("");
                        $('#total').val("");
                        $('#nama_barang').focus();
                    }
                });
            }

        });

        $('#inputpenjualan').click(function(e) {
            e.preventDefault();
            var no_fak_penj = $('#no_fak_penj').val();
            var keterangan = $('#keterangan').val();
            var subtotal = $('#subtotal').val();
            var potongan = $('#potongan').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            var kode_pelanggan = $('#kode_pelanggan').val();
            var jumlah_bayar = $('#jumlah_bayar').val();
            var sisa_bayar = $('#sisa_bayar').val();
            var jatuh_tempo = $('#jatuh_tempo').val();
            var no_so = $('#no_so').val();
            var id_sales = $('#id_sales').val();
            var kembalian = $('#kembalian').val();
            var ppn = $('#ppn').val();
            if (subtotal == "0") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
                return false;
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
                return false;
            } else if (kode_pelanggan == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Pelanggan terlebih dahulu', 'warning')
                return false;
            } else if (jumlah_bayar == "") {
                Swal.fire('Oppss..', 'Silahkan isi pembayaran terlebih dahulu', 'warning')
                return false;
            } else if (id_sales == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Sales terlebih dahulu', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>penjualan/insert_penjualan',
                    data: {
                        keterangan: keterangan,
                        id_sales: id_sales,
                        potongan: potongan,
                        sisa_bayar: sisa_bayar,
                        subtotal: subtotal,
                        no_so: no_so,
                        jatuh_tempo: jatuh_tempo,
                        tgl_transaksi: tgl_transaksi,
                        kembalian: kembalian,
                        jumlah_bayar: jumlah_bayar,
                        kode_pelanggan: kode_pelanggan,
                        ppn: ppn
                    },
                    cache: false,
                    success: function(respond) {
                        Swal.fire('Oppss..', 'Berhasil di Simpan', 'success')
                        location.href = "<?php echo base_url() ?>penjualan/input_penjualan";
                        // location.href = "<?php echo base_url() ?>penjualan/cetak_thermal/" + no_fak_penj;
                    }
                });
            }
        });

        $("#kode_barang").on('input', function() {
            var kode_barang = $('#kode_barang').val();
            var jenis_harga = $('#jenis_harga').val();
            var kode_pelanggan = $('#kode_pelanggan').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            if (kode_pelanggan == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Pelanggan terlebih dahulu', 'warning')
                $('#kode_barang').val("");
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>penjualan/get_barangbarcode',
                    data: {
                        kode_barang: kode_barang,
                        jenis_harga: jenis_harga
                    },
                    cache: false,
                    success: function(msg) {

                        data = msg.split("|");
                        if (data == 0) {
                            $("#nama_barang").val('Data Tidak Ditemukan');
                        } else {
                            $("#nama_barang").val(data[0]);
                            $("#satuan").val(data[1]);
                            $("#exp_date").val(data[2]);
                            $("#harga_modal").val(formatAngka(data[3]));
                            $("#harga_jual").val(formatAngka(data[4]));
                            $("#barangke").val(data[5]);
                            $("#stok").val(formatAngka(data[6]));
                            $("#stoks").val(data[7]);

                            var stok = $("#stok").val(data[6]);
                            var stoks = $("#stoks").val(data[7]);

                            var kode_barang = $('#kode_barang').val();
                            var qty = "1";
                            var harga_jual = $('#harga_jual').val();
                            var no_so = $('#no_so').val();
                            var kode_edit = $('#kode_edit').val();
                            var exp_date = $('#exp_date').val();
                            var barangke = $('#barangke').val();
                            var keterangan = $('#ket').val();
                            var tgl_transaksi = $('#tgl_transaksi').val();
                            var id_sales = $('#id_sales').val();
                            var kode_pelanggan = $('#kode_pelanggan').val();
                            var cekbarang = $('#cekbarang').val();
                            var barcode = "1";

                            stokakhir = stoks - stok;
                            if (stokakhir > 0) {
                                Swal.fire('Oppss..', 'Barang ada yang Exp, silahkan untuk buang terlebih dahulu..!!', 'warning')
                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url(); ?>penjualan/insert_penjualan_temp',
                                    data: {
                                        barcode: barcode,
                                        kode_barang: kode_barang,
                                        kode_edit: kode_edit,
                                        exp_date: exp_date,
                                        barangke: barangke,
                                        qty: qty,
                                        harga_jual: harga_jual,
                                        no_so: no_so,
                                        keterangan: keterangan
                                    },
                                    cache: false,
                                    success: function(msg) {
                                        view_penjualantemp();
                                        $('#ket').val("");
                                        $('#kode_barang').val("");
                                        $('#kode_edit').val(0);
                                        $('#exp_date').val("");
                                        $('#barangke').val("");
                                        $('#harga_modal').val("");
                                        $('#stok').val("");
                                        $('#satuan').val("");
                                        $('#nama_barang').val("");
                                        $('#qty').val("");
                                        $('#harga_jual').val("");
                                        $('#total').val("");
                                        $('#kode_barang').focus();
                                    }

                                });

                            }
                        }

                    }

                });
            }
        });

        $(document).on('keyup', 'body', function(e) {
            e.preventDefault();
            var charCode = (e.which) ? e.which : event.keyCode;

            if (charCode == 37) {
                $('#kode_barang').focus();
            }

            if (charCode == 39) {
                $('#potongan').focus();
            }

            if (charCode == 46) {
                clear();
            }

            if (charCode == 16) {
                // $('#kode_barang').focus();
            }
        });

        document.onkeyup = function(e) {
            var evt = window.event || e;

            if (evt.keyCode == 13 && evt.ctrlKey) {

                $('#simpan').click();

            }

        }

    });
</script>