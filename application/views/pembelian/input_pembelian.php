<style>
    div.scrolled {
        width: 100%;
        height: 450px;
        overflow: auto;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>INPUT PEMBELIAN</b></h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">No Faktur</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" readonly id="no_fak_pemb" name="no_fak_pemb" placeholder="Faktur Pembelian">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Supplier</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <select class="selectize" id="kode_supplier" name="kode_supplier" tabindex="1">
                            <option value="">-- Pilih Supplier --</option>
                            <?php foreach ($supplier->result() as $s) { ?>
                                <option value="<?php echo $s->kode_supplier; ?>"><?php echo $s->nama_supplier; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Tgl Transaksi</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input type="text" autocomplete="off" name="tgl_transaksi" id="tgl_transaksi" placeholder="Tanggal Transaksi" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="2" />
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label" style="padding-left:7px;padding-right:0px">Jatuh Tempo</label>
                    <div class="col-md-8" style="padding-left:7px;padding-right:0px">
                        <input type="text" autocomplete="off" name="jatuh_tempo" id="jatuh_tempo" placeholder="Jatuh Tempo" class="form-control form-control-sm datepicker-here" data-language="en" tabindex="3" />
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
                    <div class="col-md-2" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" readonly id="nama_barang" name="nama_barang" placeholder="Nama Barang">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="harga_modal" name="harga_modal" placeholder="Harga Modal" tabindex="5">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="qty" name="qty" placeholder="Jumlah" tabindex="6">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="diskonrp" name="diskonrp" placeholder="Diskon (Rp)" tabindex="7">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="diskonpersen" name="diskonpersen" placeholder="Dsikon (%)" tabindex="8">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" readonly id="total" name="total" placeholder="Total">
                    </div>
                    <div class="col-md-2" style="padding-left:7px;padding-right:0px">
                        <input class="form-control form-control-sm" autocomplete="off" id="ket" name="ket" placeholder="Keterangan" tabindex="9">
                    </div>
                    <div class="col-md-1" style="padding-left:7px;padding-right:0px;color:white">
                        <a class="btn btn-sm btn-info btn-block" id="simpantemp" name="simpantemp" tabindex="10"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="padding-left:7px;padding-right:0px">
                        <div class="table-responsive mb-0">
                            <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                                <thead style="background-color: #0085cd;color:white">
                                    <tr>
                                        <th style="width: 15%;">Kode</th>
                                        <th>Nama</th>
                                        <th style="width: 25%;">Harga</th>
                                        <th style="width: 20%;">Jumlah</th>
                                        <th style="width: 20%;">Total</th>
                                        <th style="width: 5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadpembeliantemp" style="font-size: 13px;">

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
                <h5 style="text-align: center;" colspan="4">PEMBAYARAN</h5>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Subtotal</label>
                    <div class="col-md-8">
                        <input class="form-control form-control-sm" readonly id="subtotal" name="subtotal" style="text-align: right;" placeholder="Jumlah Bayar">
                    </div>
                </div>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Potongan</label>
                    <div class="col-md-8">
                        <input class="form-control form-control-sm" autocomplete="off" id="potongan" name="potongan" style="text-align: right;" placeholder="Potongan" tabindex="11">
                    </div>
                </div>
                <?php if ($this->session->userdata('bayar') == "Sekarang") { ?>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label">Jumlah Bayar</label>
                        <div class="col-md-8">
                            <input class="form-control form-control-sm" autocomplete="off" id="jmlbayar" name="jmlbayar" style="text-align: right;" placeholder="Jumlah Bayar" tabindex="12">
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label">Sisa Bayar</label>
                        <div class="col-md-8">
                            <input class="form-control form-control-sm" readonly id="sisabayar" name="sisabayar" style="text-align: right;" placeholder="Sisa Bayar">
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label">Kembalian</label>
                        <div class="col-md-8">
                            <input class="form-control form-control-sm" readonly id="kembalian" name="kembalian" style="text-align: right;" placeholder="Kembalian">
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-md-4 col-form-label">Keterangan</label>
                        <div class="col-md-8">
                            <input class="form-control form-control-sm" id="keterangan" name="keterangan" placeholder="Keterangan" tabindex="13">
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <label for="example-text-input" class="col-md-4 col-form-label">Konfirmasi Pembayaran</label>
                    <div class="col-md-8">
                        <a class="btn btn-sm btn-primary btn-block" href="#" id="inputbarang" tabindex="14"><i class="fa  fa-shopping-cart"></i> Bayar</a>
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
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Input Pembayaran Hutang</h5>
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

        view_pembeliantemp();

        function view_pembeliantemp() {

            var totals = $('#totals').text();
            $('#subtotal').val(formatAngka(totals * 1));

            if (totals = "0") {
                $('#pembayaran').hide();
            } else {
                $('#pembayaran').show();
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/view_pembelian_temp',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#loadpembeliantemp").html(respond);
                }
            });

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/codeotomatis',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#no_fak_pemb").val(respond);
                }
            });
        }

        $('.caribarang').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/view_barang',
                data: '',
                cache: false,
                success: function(respond) {
                    $("#loadbarang").html(respond);
                    $("#viewbarang").modal("show");
                }
            });
        });

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

        $('#diskonrp').on("input", function() {
            var diskonrp = $('#diskonrp').val();
            var diskonrp = diskonrp.replace(/[^\d]/g, "");
            $('#diskonrp').val(formatAngka(diskonrp * 1));
        });

        $('#potongan,#jmlbayar').on("input", function() {

            var potongan = $('#potongan').val();
            var jmlbayar = $('#jmlbayar').val();
            var subtotal = $('#subtotal').val();
            var sisabayar = $('#sisabayar').val();

            var sisabayar = sisabayar.replace(/[^\d]/g, "");
            var subtotal = subtotal.replace(/[^\d]/g, "");
            var potongan = potongan.replace(/[^\d]/g, "");
            var jmlbayar = jmlbayar.replace(/[^\d]/g, "");


            $('#potongan').val(formatAngka(potongan * 1));
            $('#jmlbayar').val(formatAngka(jmlbayar * 1));

            var sisabayar = subtotal - potongan - jmlbayar;
            if (sisabayar < 1) {
                var sisabayar = 0;
            } else {
                var sisabayar = subtotal - potongan - jmlbayar;
            }

            var kembalian = jmlbayar - (subtotal - potongan);
            if (kembalian < 1) {
                var kembalian = 0;
            } else {
                var kembalian = jmlbayar - (subtotal - potongan);
            }

            potonganlebih = subtotal - potongan;
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

        $('.filterkategori').click(function(e) {
            e.preventDefault();
            var kode_kategori = $(this).attr('data-filter');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/view_barang',
                data: {
                    kode_kategori: kode_kategori
                },
                cache: false,
                success: function(respond) {
                    $("#loadviewbarang").html(respond);
                }
            });
        });

        $('.inputbarang').click(function(e) {
            e.preventDefault();
            var kode_barang   = $('#kode_barang').val();
            var qty           = $('#qty').val();
            var harga_modal   = $('#harga_modal').val();
            var diskonrp      = $('#diskonrp').val();
            var diskonpersen  = $('#diskonpersen').val();
            var total         = $('#total').val();
            var keterangan    = $('#keterangan').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>pembelian/insert_pembelian_temp',
                data: {
                    kode_barang   : kode_barang,
                    qty           : qty,
                    harga_modal   : harga_modal,
                    diskonrp      : diskonrp,
                    diskonpersen  : diskonpersen,
                    total         : total,
                    keterangan    : keterangan
                },
                cache: false,
                success: function(respond) {
                    view_pembeliantemp();
                }
            });
        });

        $('#inputpembelian').click(function(e) {
            e.preventDefault();
            var keterangan = $('#keterangan').val();
            var total = $('#total').val();
            var jmlbayar = $('#jmlbayar').val();
            var potongan = $('#potongan').val();
            var kembalian = $('#kembalian').val();
            if (total == "0") {
                Swal.fire('Oppss..', 'Silahkan pilih Barang terlebih dahulu', 'warning')
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>pembelian/insert_pembelian',
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