<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">LAPORAN KARTU STOK GUDANG</h2>
                <form class="form-horizontal" id="FormID" method="post" target="_blank" action="<?php echo base_url(); ?>laporangudang/cetak_kartu_gudang" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select class="selectize" id="bulan" name="bulan">
                                            <option value="">Bulan</option>
                                            <?php for ($a = 1; $a <= 12; $a++) { ?>
                                                <option value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select class="selectize" id="tahun" name="tahun">
                                            <option value="">Tahun</option>
                                            <?php for ($t = 2019; $t <= $tahun; $t++) { ?>
                                                <option value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="selectize" id="kode_barang" name="kode_barang" tabindex="1">
                                            <option value="">-- Semua Barang --</option>
                                            <?php foreach ($barang->result() as $s) { ?>
                                                <option value="<?php echo $s->kode_barang; ?>"><?php echo $s->nama_barang; ?></option>
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

            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            var kode_barang = $('#kode_barang').val();
            if (bulan == "") {
                Swal.fire('Oppss..', 'Pilih Bulan terlebih dahulu', 'warning')
                return false;
            } else if (tahun == "") {
                Swal.fire('Oppss..', 'Pilih Tahun terlebih dahulu', 'warning')
                return false;

            } else if (kode_barang == "") {
                Swal.fire('Oppss..', 'Pilih Barang terlebih dahulu', 'warning')
                return false;

            }else{
                return true;
            }
        });


    });
</script>