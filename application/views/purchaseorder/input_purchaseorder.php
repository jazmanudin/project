<style>
    div.scrolled {
        width: 100%;
        height: 450px;
        overflow: auto;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>INPUT PURCHASE ORDER</b></h5>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="no_po" name="no_po" placeholder="No PO">
                        <input type="hidden" autocomplete="off" name="kode_edit" id="kode_edit" value="0" class="form-control form-control-sm" />
                    </div>
                    <div class="col-md-3" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autofocus id="nama_supplier" name="nama_supplier" placeholder="Nama Supplier" tabindex="1">
                    </div>
                    <div class="col-md-3" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="kode_supplier" name="kode_supplier" placeholder="Kode Supplier">
                    </div>
                    <div class="col-md-3" style="padding-left:2px;padding-right:0px">
                        <input type="text" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" name="tgl_transaksi" id="tgl_transaksi" placeholder="Tanggal Transaksi" class="form-control form-control-sm datepicker-here" data-language="en" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card" style="background-color: #3051d3;">
            <div class="card-header bg-transparent">
                <h4 style="text-align: left;color:white">Total <i class="fa fa-shopping-cart"></i></h4>
                <blockquote class="card-bodyquote">
                    <h3 style="text-align: right;color:white" id="totalkeranjang"></h3>
                </blockquote>
            </div>
        </div>
    </div> -->
</div>
<div class="row">

    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <a class="btn btn-info btn-sm btn-block caribarang" href="#" tabindex="3"><i class="fa fa-search"></i> Cari</a>
                    </div> -->
                    <div class="col-md-3" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" id="nama_barang" name="nama_barang" placeholder="Nama Barang" tabindex="2">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="kode_barang" name="kode_barang" placeholder="Barcode" tabindex="3">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="satuan" name="satuan" placeholder="Satuan">
                    </div>
                    <div class="col-md-3" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="ket" name="ket" placeholder="Keterangan" tabindex="4">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly autocomplete="off" style="text-align:right" id="harga_modal" name="harga_modal" placeholder="Harga" tabindex="5">
                    </div>
                    <!-- <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly autocomplete="off" id="stok" name="stok" placeholder="Stok">
                    </div> -->
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" autocomplete="off" id="qty" name="qty" placeholder="Jumlah" tabindex="6">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px">
                        <input type="text" class="form-control form-control-sm" readonly id="total" style="text-align:right" name="total" placeholder="Total">
                    </div>
                    <div class="col-md-1" style="padding-left:2px;padding-right:0px;color:white">
                        <a class="btn btn-info btn-sm btn-block" id="inputbarang" href="#" tabindex="7"><i class="fa fa-plus"></i> Tambah</a>
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
                                <tbody id="loadpurchaseordertemp" style="font-size: 13px;">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
    </div>
    <div class="col-sm-4" id="pembayaran">
        <div class="card">
            <div class="card-body">
                <!-- <h5 style="text-align: center;" colspan="4">PEMBAYARAN</h5> -->
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Subtotal</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" readonly id="subtotal" name="subtotal" style="text-align: right;" placeholder="Jumlah Bayar">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Keterangan</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" id="keterangan" name="keterangan" placeholder="Keterangan" tabindex="8">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">PPN</label>
                    <div class="col-sm-8">
                        <select class="form-control form-control-sm" id="ppn" name="ppn" tabindex="9">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Konfirmasi</label>
                    <div class="col-md-8">
                        <a class="btn btn-sm btn-primary btn-block" href="#" id="inputpurchaseorder" tabindex="15"><i class="fa  fa-save"></i> Simpan</a>
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

        autocomplete();
        view_purchaseordertemp();

        function view_purchaseordertemp() {

            var no_po = $('#no_po').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>purchaseorder/view_purchaseorder_temp',
                data: {
                    no_po: no_po
                },
                cache: false,
                success: function(respond) {
                    $("#loadpurchaseordertemp").html(respond);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>purchaseorder/codeotomatis',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#no_po").val(respond);
                }
            });
        }

        function autocomplete() {

            $('#nama_supplier').autocomplete({
                serviceUrl: "<?php echo base_url(); ?>purchaseorder/get_supplier/",
                onSelect: function(suggestions) {
                    $('#nama_supplier').val(suggestions.nama_supplier);
                    $('#kode_supplier').val(suggestions.kode_supplier);

                    $('#nama_barang').autocomplete({
                        serviceUrl: "<?php echo base_url(); ?>purchaseorder/get_barang/",
                        onSelect: function(suggestions) {

                            $('#nama_barang').val(suggestions.nama_barang);
                            $('#kode_barang').val(suggestions.kode_barang);
                            $('#satuan').val(suggestions.satuan);
                            $('#harga_modal').val(formatAngka(suggestions.harga_modal));
                            // $('#stok').val(formatAngka(suggestions.stok));
                            view_purchaseordertemp();

                        }
                    });

                }
            });

        }

        $('#harga_modal').on("input", function() {
            var harga_modal = $('#harga_modal').val();
            var harga_modal = harga_modal.replace(/[^\d]/g, "");
            $('#harga_modal').val(formatAngka(harga_modal * 1));
        });

        $('#qty').on("input", function() {
            var qty = $('#qty').val();
            var qty = qty.replace(/[^\d]/g, "");
            $('#qty').val(formatAngka(qty * 1));
        });

        $('#qty,#harga_modal').on("input", function() {
            var qty = $('#qty').val();
            var harga_modal = $('#harga_modal').val();

            var qty = qty.replace(/[^\d]/g, "");
            var harga_modal = harga_modal.replace(/[^\d]/g, "");

            var hasiltotal = qty * harga_modal;

            $('#total').val(formatAngka(hasiltotal * 1));
        });

        $('#inputbarang').click(function(e) {
            e.preventDefault();
            var kode_barang = $('#kode_barang').val();
            var qty = $('#qty').val();
            var harga_modal = $('#harga_modal').val();
            var kode_edit = $('#kode_edit').val();
            var diskon = $('#diskon').val();
            var total = $('#total').val();
            var keterangan = $('#ket').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            var kode_supplier = $('#kode_supplier').val();

            if (kode_barang == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
            } else if (kode_supplier == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Supllier terlebih dahulu', 'warning')
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
            } else if (qty == "") {
                Swal.fire('Oppss..', 'Qty tidak boleh kosong', 'warning')
            } else if (harga_modal == "") {
                Swal.fire('Oppss..', 'Harga Modal tidak boleh kosong', 'warning')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>purchaseorder/insert_purchaseorder_temp',
                    data: {
                        kode_barang: kode_barang,
                        kode_edit: kode_edit,
                        qty: qty,
                        harga_modal: harga_modal,
                        total: total,
                        keterangan: keterangan
                    },
                    cache: false,
                    success: function(respond) {
                        view_purchaseordertemp();
                        $('#ket').val("");
                        $('#kode_barang').val("");
                        $('#kode_edit').val(0);
                        $('#satuan').val("");
                        $('#nama_barang').val("");
                        $('#qty').val("");
                        $('#harga_modal').val("");
                        $('#total').val("");
                        $('#nama_barang').focus();
                    }
                });
            }
        });


        $('#inputpurchaseorder').click(function(e) {
            e.preventDefault();
            var keterangan = $('#keterangan').val();
            var subtotal = $('#subtotal').val();
            var potongan = "0";
            var tgl_transaksi = $('#tgl_transaksi').val();
            var kode_supplier = $('#kode_supplier').val();
            var ppn = $('#ppn').val();
            if (subtotal == "0") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
                return false;
            } else if (tgl_transaksi == "") {
                Swal.fire('Oppss..', 'Tanggal transaksi tidak boleh kosong', 'warning')
                return false;
            } else if (kode_supplier == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Supplier terlebih dahulu', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>purchaseorder/insert_purchaseorder',
                    data: {
                        keterangan: keterangan,
                        potongan: potongan,
                        subtotal: subtotal,
                        tgl_transaksi: tgl_transaksi,
                        kode_supplier: kode_supplier,
                        ppn: ppn
                    },
                    cache: false,
                    success: function(respond) {
                        Swal.fire('Oppss..', 'Berhasil di Simpan', 'success')
                        location.reload();
                    }
                });
            }
        });

        $("#kode_barang").on('input', function() {
            var kode_barang = $('#kode_barang').val();
            var kode_supplier = $('#kode_supplier').val();
            var tgl_transaksi = $('#tgl_transaksi').val();
            if (kode_supplier == "") {
                Swal.fire('Oppss..', 'Silahkan pilih Pelanggan terlebih dahulu', 'warning')
                $('#kode_barang').val("");
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>purchaseorder/get_barangbarcode',
                    data: {
                        kode_barang: kode_barang
                    },
                    cache: false,
                    success: function(msg) {

                        data = msg.split("|");
                        if (data == 0) {
                            $("#nama_barang").val('Data Tidak Ditemukan');
                        } else {
                            $("#nama_barang").val(data[0]);
                            $("#satuan").val(data[1]);
                            $("#harga_modal").val(formatAngka(data[2]));

                            var kode_barang = $('#kode_barang').val();
                            var qty = "1";
                            var harga_modal = $('#harga_modal').val();
                            var kode_edit = $('#kode_edit').val();
                            var keterangan = $('#ket').val();

                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url(); ?>purchaseorder/insert_purchaseorder_temp',
                                data: {
                                    kode_barang: kode_barang,
                                    kode_edit: kode_edit,
                                    qty: qty,
                                    harga_modal: harga_modal,
                                    keterangan: keterangan
                                },
                                cache: false,
                                success: function(msg) {
                                    view_purchaseordertemp();
                                    $('#ket').val("");
                                    $('#kode_barang').val("");
                                    $('#kode_edit').val(0);
                                    $('#harga_modal').val("");
                                    $('#satuan').val("");
                                    $('#nama_barang').val("");
                                    $('#qty').val("");
                                    $('#total').val("");
                                    $('#kode_barang').focus();
                                }

                            });

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
                $('#keterangan').focus();
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