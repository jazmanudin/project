<div class="col-lg-6">
    <div class="card">
        <div class="card-body">
            <h4 align="center">Edit Data Barang</h4>
            <form autocomplete="off" id="form" class="pelangganForm" method="POST" enctype="multipart/form-data" data-action="<?php echo base_url(); ?>barang/edit_barang">

                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text"  value="<?php echo $getdata['kode_barang']; ?>" name="kode_barang" id="kode_barang" class="data_kosong form-control form-control-sm" placeholder="Kode Barang" />
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text"  value="<?php echo $getdata['nama_barang']; ?>" name="nama_barang" id="nama_barang" class="data_kosong form-control form-control-sm" placeholder="Nama Barang" />
                </div>
                <div class="form-group">
                    <label>Satuan Barang</label>
                    <input type="text"  value="<?php echo $getdata['satuan']; ?>" name="satuan" id="satuan" class="data_kosong form-control form-control-sm" placeholder="Satuan Barang" />
                </div>
                <div class="form-group">
                    <label>Harga Modal</label>
                    <input type="text"  value="<?php echo number_format($getdata['harga_modal']); ?>" name="harga_modal" id="harga_modal" class="data_kosong form-control form-control-sm" placeholder="Harga Modal" />
                </div>
                <div class="form-group">
                    <label>Harga Jual</label>
                    <input type="text"  value="<?php echo number_format($getdata['harga']); ?>" name="harga" id="harga" class="data_kosong form-control form-control-sm" placeholder="Harga Jual" />
                </div>
                <div class="form-group">
                    <label>Diskon</label>
                    <input type="text"  value="<?php echo number_format($getdata['diskon']); ?>" name="diskon" id="diskon" class="data_kosong form-control form-control-sm" placeholder="Diskon" />
                </div>
                <div class="form-group">
                    <label>Kategori Barang</label>
                    <select class="selectize" id="kode_kategori" name="kode_kategori">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($kategori as $k) { ?>
                            <option <?php if ($getdata['kode_kategori'] == $k->kode_kategori) {
                                    echo "selected";
                                } ?> value="<?php echo $k->kode_kategori; ?>"><?php echo $k->nama_kategori; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jenis Barang</label>
                    <select class="selectize" id="jenis_barang" name="jenis_barang">
                        <option value="">Pilih Jenis Barang</option>
                        <option <?php if ($getdata['jenis_barang'] == "Bahan Kemasan") {
                                    echo "selected";
                                } ?> value="Bahan Kemasan">Bahan Kemasan</option>
                        <option <?php if ($getdata['jenis_barang'] == "Produksi") {
                                    echo "selected";
                                } ?> value="Produksi">Produksi</option>
                        <option <?php if ($getdata['jenis_barang'] == "Bahan Baku") {
                                    echo "selected";
                                } ?> value="Bahan Baku">Bahan Baku</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text"  value="<?php echo $getdata['keterangan']; ?>" name="keterangan" id="keterangan" class="data_kosong form-control form-control-sm" placeholder="Keterangan" />
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="hidden" name="fotoold" id="fotoold" value="<?php echo $getdata['foto']; ?>" class="data_kosong form-control form-control-sm" placeholder="Foto" />
                    <input type="file" name="foto" id="foto" class="data_kosong form-control form-control-sm" placeholder="Foto" />
                </div>

                <div class="form-group mb-0">
                    <button type="submit" name="submit" class="btn btn-primary btn-sm waves-effect waves-light mr-1">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
            return angka;
        }

        $('#diskon').on("input", function() {
            var diskon = $('#diskon').val();
            var diskon = diskon.replace(/[^\d]/g, "");
            $('#diskon').val(formatAngka(diskon * 1));
        });

        $('#harga_modal').on("input", function() {
            var harga_modal = $('#harga_modal').val();
            var harga_modal = harga_modal.replace(/[^\d]/g, "");
            $('#harga_modal').val(formatAngka(harga_modal * 1));
        });

        $('#harga').on("input", function() {
            var harga = $('#harga').val();
            var harga = harga.replace(/[^\d]/g, "");
            $('#harga').val(formatAngka(harga * 1));
        });

        $("#form").submit(function() {
            var action = $(this).attr('data-action');
            var data_kosong = $('.data_kosong').val();
            if (data_kosong == "") {
                Swal.fire("Oopss", "Data Tidak Boleh Kosong", "warning");
                $('#data_kosong').focus();
                return false;
            } else {
                location.href = action;
                return true;
            }
        });
    });
</script>