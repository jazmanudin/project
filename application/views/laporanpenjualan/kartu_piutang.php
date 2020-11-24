<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">LAPORAN KARTU PIUTANG</h2>
                <form class="form-horizontal" method="post" target="_blank" action="<?php echo base_url(); ?>laporanpenjualan/cetak_kartu_piutang" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input type="text" name="dari" id="dari" required placeholder="Dari" class="form-control form-control-sm datepicker-here" data-language="en" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input type="text" name="sampai" id="sampai" required placeholder="Sampai" class="form-control form-control-sm datepicker-here" data-language="en" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="selectize" id="kode_pelanggan" name="kode_pelanggan" tabindex="1">
                                            <option value="">-- Semua Pelanggan --</option>
                                            <?php foreach ($pelanggan->result() as $s) { ?>
                                                <option value="<?php echo $s->kode_pelanggan; ?>"><?php echo $s->nama_pelanggan; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" align="right">
                                <button type="submit" name="submit" id="submit" class="btn btn-info btn-sm mr-2">CETAK</button>
                                <button type="submit" name="export" id="export" class="btn btn-primary btn-sm mr-2">EXPORT</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {

        $('#submit,#export').click(function() {

            var dari = $('#dari').val();
            var sampai = $('#sampai').val();
            var kode_barang = $('#kode_barang').val();
            if (dari == "") {
                Swal.fire('Oppss..', 'Pilih Periode terlebih dahulu', 'warning')
                return false;
            } else if (sampai == "") {
                Swal.fire('Oppss..', 'Pilih Periode terlebih dahulu', 'warning')
                return false;
            } else {
                return true;
            }
        });

    });
</script>