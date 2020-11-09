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
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">No pengeluaran</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" readonly id="no_fak_pemb" name="no_fak_pemb" placeholder="No pengeluaran">
                        <input type="hidden" autocomplete="off" name="cekbarang" id="cekbarang" placeholder="Tanggal Transaksi" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="2" />
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Tgl Transaksi</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input type="text" autocomplete="off" value="<?php echo Date('Y-m-d');?>" name="tgl_transaksi" id="tgl_transaksi" placeholder="Tanggal Transaksi" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="2" />
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Jenis Pengeluaran</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <select class="selectize" name="jenis_pengeluaran" id="jenis_pengeluaran">
                            <option value="">-- Pilih Jenis Keluar--</option>
                            <option value="Retur">Retur</option>
                            <option value="Buang">Buang</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Keterangan</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input type="text" autocomplete="off" name="keterangan" id="keterangan" placeholder="Keterangan" class="form-control form-control-sm" tabindex="3" />
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
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <a class="btn btn-info btn-sm btn-block caribarang" href="#" tabindex="3">Cari</a>
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="kode_barang" name="kode_barang" placeholder="Kode" tabindex="4">
                    </div>
                    <div class="col-md-3" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" readonly id="nama_barang" name="nama_barang" placeholder="Nama Barang">
                    </div>
                    <div class="col-md-2" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" readonly id="satuan" name="satuan" placeholder="Satuan">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="qty" name="qty" placeholder="Jumlah" tabindex="6">
                    </div>
                    <div class="col-md-3" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="ket" name="ket" placeholder="Keterangan" tabindex="9">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px;color:white">
                        <a class="btn btn-sm btn-info btn-block" id="simpanbarang" name="simpanbarang" tabindex="10"><i class="fa fa-plus"></i></a>
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
                                        <th>Keterangan</th>
                                        <th style="width: 5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadpengeluarantemp" style="font-size: 13px;">

                                </tbody>

                            </table>
                        </div>
                        <br>
                        <a class="btn btn-sm btn-primary btn-block" href="#" id="simpanpengeluaran" tabindex="14"><i class="fa  fa-shopping-cart"></i> Simpan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewbarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loadbarang">

            </div>
            <div class="modal-footer">
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
        cekbarang();

        function cekbarang() {
            var kode_barang = $('#kode_barang').val();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pengeluaran/cekbarang',
                data: {
                    kode_barang: kode_barang
                },
                cache: false,
                success: function(respond) {
                    $("#cekbarang").val(respond);
                }
            });
        }

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
                    $("#no_fak_pemb").val(respond);
                }
            });
        }

        $('.caribarang').click(function(e) {
            e.preventDefault();
            var jenis_pengeluaran = $('#jenis_pengeluaran').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
                return false;
            } else if (jenis_pengeluaran == "") {
                Swal.fire('Oppss..', 'Silahkan Pilih Jenis Keluar Terlebih Dahulu', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pengeluaran/view_barang',
                    data: '',
                    cache: false,
                    success: function(respond) {
                        $("#loadbarang").html(respond);
                        $("#viewbarang").modal("show");
                    }
                });
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
            var cekbarang = $('#cekbarang').val();

            if (kode_barang == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
            } else if (cekbarang >= 1) {
                Swal.fire('Oppss..', 'Barang sudah ada', 'warning')
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
                        qty: qty,
                        keterangan: keterangan
                    },
                    cache: false,
                    success: function(respond) {
                        view_pengeluarantemp();
                        $('#ket').val("");
                        $('#kode_barang').val("");
                        $('#nama_barang').val("");
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
                Swal.fire('Oppss..', 'Pilih Jenis Keluar', 'warning')
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

    });
</script>