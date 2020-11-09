<div class="col-lg-6">
    <div class="card">
        <div class="card-body">
            <h5 style="text-align: center;color:black;"><b>INPUT BARANG</b></h5>
            <form autocomplete="off" id="form" class="pelangganForm" method="POST" enctype="multipart/form-data" data-action="<?php echo base_url(); ?>barang/input_barang">

                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" name="kode_barang" id="kode_barang" class="data_kosong form-control form-control-sm" placeholder="Kode Barang" />
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="data_kosong form-control form-control-sm" placeholder="Nama Barang" />
                </div>
                <div class="form-group">
                    <label>Satuan Barang</label>
                    <input type="text" name="satuan" id="satuan" class="data_kosong form-control form-control-sm" placeholder="Satuan Barang" />
                </div>
                <div class="form-group">
                    <label>Harga Modal</label>
                    <input type="text" name="harga_modal" id="harga_modal" class="data_kosong form-control form-control-sm" placeholder="Harga Modal" />
                </div>
                <div class="form-group">
                    <label>Harga Pel. Tetap</label>
                    <input type="text" name="pelanggan_tetap" id="pelanggan_tetap" class="data_kosong form-control form-control-sm" placeholder="Harga Pel. Tetap" />
                </div>
                <div class="form-group">
                    <label>Harga Pel. Tidak Tetap</label>
                    <input type="text" name="tidak_tetap" id="tidak_tetap" class="data_kosong form-control form-control-sm" placeholder="Harga Pel. Tidak Tetap" />
                </div>
                <div class="form-group">
                    <label>Harga Grosir</label>
                    <input type="text" name="grosir" id="grosir" class="data_kosong form-control form-control-sm" placeholder="Harga Grosir" />
                </div>
                <div class="form-group">
                    <label>Harga Eceran</label>
                    <input type="text" name="eceran" id="eceran" class="data_kosong form-control form-control-sm" placeholder="Harga Eceran" />
                </div>
                <div class="form-group">
                    <label>Harga Lainnya</label>
                    <input type="text" name="lainnya" id="lainnya" class="data_kosong form-control form-control-sm" placeholder="Harga Lainnya" />
                </div>
                <div class="form-group">
                    <label>Diskon</label>
                    <input type="text" name="diskon" id="diskon" class="data_kosong form-control form-control-sm" placeholder="Diskon" />
                </div>
                <div class="form-group">
                    <label>Kategori Barang</label>
                    <select class="selectize data_kosong" id="kode_kategori" name="kode_kategori">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($kategori as $k) { ?>
                            <option value="<?php echo $k->kode_kategori; ?>"><?php echo $k->nama_kategori; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <!-- <div class="form-group">
                    <label>Jenis Barang</label>
                    <select class="selectize data_kosong" id="jenis_barang" name="jenis_barang">
                        <option value="">Pilih Jenis Barang</option>
                        <option value="Bahan Kemasan">Bahan Kemasan</option>
                        <option value="Produksi">Produksi</option>
                        <option value="Bahan Baku">Bahan Baku</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div> -->
                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" class="data_kosong form-control form-control-sm" placeholder="Keterangan" />
                </div>
                <div class="form-group">
                    <label>Foto</label>
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