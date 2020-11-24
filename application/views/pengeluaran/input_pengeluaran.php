<style>
    div.scrolled {
        width: 100%;
        height: 450px;
        overflow: auto;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>INPUT PENGELUARAN</b></h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">No Pengeluaran</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" readonly id="no_pengeluaran" autofocus name="no_pengeluaran" placeholder="No pengeluaran" tabindex="1">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Jenis Pengeluaran</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <select class="selectize" name="jenis_pengeluaran" id="jenis_pengeluaran" tabindex="2">
                            <option value="">-- Pilih Jenis Pengeluaran--</option>
                            <option value="Retur">Retur</option>
                            <option value="Buang">Buang</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Keterangan</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input type="text" autocomplete="off" name="keterangan" id="keterangan" placeholder="Keterangan" class="form-control form-control-sm" tabindex="2" />
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Tgl Transaksi</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input type="text" autocomplete="off" value="<?php echo Date('Y-m-d'); ?>" name="tgl_transaksi" id="tgl_transaksi" placeholder="Tanggal Transaksi" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="3" />
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
                    <div class="col-md-2" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="kode_barang" name="kode_barang" placeholder="Kode" tabindex="4">
                    </div>
                    <div class="col-md-3" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" id="nama_barang" name="nama_barang" placeholder="Nama Barang" tabindex="5">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" readonly id="satuan" name="satuan" placeholder="Satuan">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" readonly autocomplete="off" id="exp_date" name="exp_date" placeholder="Exp Date">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" readonly autocomplete="off" id="stok" name="stok" placeholder="Stok">
                    </div>
                    <div class="col-md-1" hidden style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="barangke" name="barangke" placeholder="Barangke">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="qty" name="qty" placeholder="Jumlah" tabindex="6">
                    </div>
                    <div class="col-md-2" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="ket" name="ket" placeholder="Keterangan" tabindex="7">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px;color:white">
                        <a class="btn btn-sm btn-info btn-block" href="#" id="simpanbarang" tabindex="8"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="padding-left:7px;padding-right:0px">
                        <div class="table-responsive mb-0">
                            <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                                <thead style="background-color: #0085cd;color:white">
                                    <tr>
                                        <th style="width: 5%;">Kode</th>
                                        <th>Nama</th>
                                        <th style="width: 10%;">Satuan</th>
                                        <th style="width: 10%;">Jumlah</th>
                                        <th style="width: 10%;">Exp Date</th>
                                        <th>Keterangan</th>
                                        <th style="width: 5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadpengeluarantemp" style="font-size: 13px;">

                                </tbody>

                            </table>
                        </div>
                        <br>
                        <a class="btn btn-sm btn-primary btn-block" href="#" id="simpanpengeluaran" tabindex="9"><i class="fa  fa-shopping-cart"></i> Simpan</a>
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

        view_pengeluarantemp();
    
        function view_pengeluarantemp() {

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pengeluaran/view_pengeluaran_temp',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#loadpengeluarantemp").html(respond);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pengeluaran/codeotomatis',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#no_pengeluaran").val(respond);
                }
            });
        }

        $('#nama_barang').autocomplete({
            serviceUrl: "<?php echo base_url(); ?>pengeluaran/get_barang/",
            onSelect: function(suggestions) {

                $('#nama_barang').val(suggestions.nama_barang);
                $('#kode_barang').val(suggestions.kode_barang);
                $('#satuan').val(suggestions.satuan);
                $('#exp_date').val(suggestions.exp_date);
                $('#barangke').val(suggestions.barangke);
                $('#stok').val(suggestions.stok);
                view_pengeluarantemp();
            }
        });

        $('#qty').on("input", function() {
            var qty = $('#qty').val();
            var qty = qty.replace(/[^\d]/g, "");
            $('#qty').val(formatAngka(qty * 1));
        });

        $('#simpanbarang').click(function(e) {
            e.preventDefault();
            var kode_barang = $('#kode_barang').val();
            var qty = $('#qty').val();
            var keterangan = $('#ket').val();
            var jenis_pengeluaran = $('#jenis_pengeluaran').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            var barangke = $('#barangke').val();
            var exp_date = $('#exp_date').val();

            if (kode_barang == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
            } else if (jenis_pengeluaran == "") {
                Swal.fire('Oppss..', 'Asal Barang tidak boleh kosong', 'warning')
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
            } else if (qty == "") {
                Swal.fire('Oppss..', 'Qty tidak boleh kosong', 'warning')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pengeluaran/insert_pengeluaran_temp',
                    data: {
                        kode_barang: kode_barang,
                        exp_date: exp_date,
                        barangke: barangke,
                        qty: qty,
                        keterangan: keterangan
                    },
                    cache: false,
                    success: function(respond) {
                        view_pengeluarantemp();
                        $('#ket').val("");
                        $('#kode_barang').val("");
                        $('#nama_barang').val("");
                        $('#satuan').val("");
                        $('#exp_date').val("");
                        $('#barnagke').val("");
                        $('#stok').val("");
                        $('#qty').val("");
                    }
                });
            }
        });

        $('#simpanpengeluaran').click(function(e) {
            e.preventDefault();
            var keterangan = $('#keterangan').val();
            var jenis_pengeluaran = $('#jenis_pengeluaran').val();
            var tgl_transaksi = $('#tgl_transaksi').val();

            if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
                return false;
            } else if (jenis_pengeluaran == "") {
                Swal.fire('Oppss..', 'Tanggal jatuh tempo tidak boleh kosong', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pengeluaran/insert_pengeluaran',
                    data: {
                        keterangan: keterangan,
                        tgl_transaksi: tgl_transaksi,
                        jenis_pengeluaran: jenis_pengeluaran
                    },
                    cache: false,
                    success: function(respond) {
                        Swal.fire('Oppss..', 'Berhasil di Simpan', 'success')
                        location.reload();
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
                $('#ket').focus();
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