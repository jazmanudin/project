<style>
    div.scrolled {
        width: 100%;
        height: 450px;
        overflow: auto;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>EDIT PEMASUKAN</b></h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">No Pemasukan</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" value="<?php echo $getdata['no_pemasukan'];?>" readonly id="no_pemasukan" name="no_pemasukan" placeholder="No Pemasukan" tabindex="1">
                        <input type="hidden" autocomplete="off" name="cekbarang" id="cekbarang" class="form-control form-control-sm datepicker-here" data-language="en" />
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Jenis Pemasukan</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <select class="selectize" name="jenis_pemasukan" id="jenis_pemasukan" tabindex="2">
                            <option value="">-- Pilih Jenis Pemasukan--</option>
                            <option <?php if($getdata['jenis_pemasukan'] == "Pengembalian Retur"){ echo "selected"; } ?> value="Pengembalian Retur">Pengembalian Retur</option>
                            <option <?php if($getdata['jenis_pemasukan'] == "Lainnya"){ echo "selected"; } ?> value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Keterangan</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input type="text" autocomplete="off" value="<?php echo $getdata['keterangan'];?>" name="keterangan" id="keterangan" placeholder="Keterangan" class="form-control form-control-sm" tabindex="2" />
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Tgl Transaksi</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input type="text" autocomplete="off" value="<?php echo $getdata['tgl_transaksi'];?>" name="tgl_transaksi" id="tgl_transaksi" placeholder="Tanggal Transaksi" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="3" />
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
                        <input type="text" autocomplete="off" name="exp_date" id="exp_date" placeholder="Exp Date" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="6" />
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="qty" name="qty" placeholder="Jumlah" tabindex="6">
                    </div>
                    <div class="col-md-3" style="padding-left:7px;padding-right:0px">
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
                                        <th style="width: 10%;">Exp Date</th>
                                        <th style="width: 10%;">Jumlah</th>
                                        <th>Keterangan</th>
                                        <th style="width: 5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadpemasukandetail" style="font-size: 13px;">

                                </tbody>

                            </table>
                        </div>
                        <br>
                        <a class="btn btn-sm btn-primary btn-block" href="#" id="simpanpemasukan" tabindex="9"><i class="fa  fa-shopping-cart"></i> Simpan</a>
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

        view_pemasukandetail();

        function view_pemasukandetail() {

            var no_pemasukan = $('#no_pemasukan').val();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pemasukan/view_pemasukan_detail',
                data: 
                {
                    no_pemasukan : no_pemasukan
                },
                cache: false,
                success: function(respond) {
                    $("#loadpemasukandetail").html(respond);
                }
            });
        }

        $('#nama_barang').autocomplete({
            serviceUrl: "<?php echo base_url(); ?>pemasukan/get_barang/",
            onSelect: function(suggestions) {

                $('#nama_barang').val(suggestions.nama_barang);
                $('#kode_barang').val(suggestions.kode_barang);
                $('#satuan').val(suggestions.satuan);
                view_pemasukandetail();
            }
        });

        $('#qty').on("input", function() {
            var qty = $('#qty').val();
            var qty = qty.replace(/[^\d]/g, "");
            $('#qty').val(formatAngka(qty * 1));
        });

        $('#simpanbarang').click(function(e) {
            e.preventDefault();
            var no_pemasukan = $('#no_pemasukan').val();
            var kode_barang = $('#kode_barang').val();
            var qty = $('#qty').val();
            var keterangan = $('#ket').val();
            var jenis_pemasukan = $('#jenis_pemasukan').val();
            var exp_date = $('#exp_date').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            var cekbarang = $('#cekbarang').val();

            if (kode_barang == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
            } else if (cekbarang >= 1) {
                Swal.fire('Oppss..', 'Barang sudah ada', 'warning')
            } else if (jenis_pemasukan == "") {
                Swal.fire('Oppss..', 'Asal Barang tidak boleh kosong', 'warning')
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
            } else if (qty == "") {
                Swal.fire('Oppss..', 'Qty tidak boleh kosong', 'warning')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pemasukan/insert_pemasukan_detail',
                    data: {
                        no_pemasukan: no_pemasukan,
                        kode_barang: kode_barang,
                        qty: qty,
                        exp_date: exp_date,
                        keterangan: keterangan
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
            }
        });

        $('#simpanpemasukan').click(function(e) {
            e.preventDefault();
            var no_pemasukan = $('#no_pemasukan').val();
            var keterangan = $('#keterangan').val();
            var jenis_pemasukan = $('#jenis_pemasukan').val();
            var tgl_transaksi = $('#tgl_transaksi').val();

            if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
                return false;
            } else if (jenis_pemasukan == "") {
                Swal.fire('Oppss..', 'Tanggal jatuh tempo tidak boleh kosong', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pemasukan/update_pemasukan',
                    data: {
                        no_pemasukan: no_pemasukan,
                        keterangan: keterangan,
                        tgl_transaksi: tgl_transaksi,
                        jenis_pemasukan: jenis_pemasukan
                    },
                    cache: false,
                    success: function(respond) {
                        Swal.fire('Oppss..', 'Berhasil di Simpan', 'success')
                        location.href = "<?php echo base_url();?>pemasukan/view_pemasukan";
                    }
                });
            }
        });

        // $("#kode_barang").on('input', function() {
        //     var kode_barang     = $('#kode_barang').val();
        //     var jenis_pemasukan = $('#jenis_pemasukan').val();
        //     if (jenis_pemasukan == "") {
        //         Swal.fire('Oppss..', 'Silahkan Pilih Jenis Pemasukan terlebih dahulu', 'warning')
        //         $('#kode_barang').val("");
        //     } else {
        //         $.ajax({
        //             type: 'POST',
        //             url: '<?php echo base_url(); ?>pembelian/get_barangbarcode',
        //             data: {
        //                 kode_barang: kode_barang
        //             },
        //             cache: false,
        //             success: function(msg) {

        //                 data = msg.split("|");
        //                 if (data == 0) {
        //                     $("#nama_barang").val('Data Tidak Ditemukan');
        //                 } else {
        //                     $("#nama_barang").val(data[0]);
        //                     $("#satuan").val(data[1]);
        //                     $("#harga_modal").val(formatAngka(data[2]));
        //                     $("#ket").focus()
        //                 }
        //             }

        //         });
        //     }
        // });

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