<div class="table-rep-plugin">
    <div class="table-responsive mb-0">
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead id="datatable" style="background-color:#0085cd;color:white;">
                <tr>
                    <th>No Faktur</th>
                    <th>No PO</th>
                    <th>Tanggal Transaksi</th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $pemb['no_fak_pemb']; ?></td>
                    <td><?php echo $pemb['no_po']; ?></td>
                    <td><?php echo $pemb['tgl_transaksi']; ?></td>
                    <td><?php echo $pemb['kode_supplier']; ?></td>
                    <td><?php echo $pemb['nama_supplier']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <h5>Barang</h5>
    <div class="table-responsive mb-0">
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead id="datatable" style="background-color:#0085cd;color:white;">
                <tr>
                    <th style="width: 5%;">Kode</th>
                    <th style="width: 40%;">Nama Barang</th>
                    <th style="width: 5%;">Satuan</th>
                    <th>Keterangan</th>
                    <th style="width: 13%;">Exp Date</th>
                    <th style="width: 8%;">Jumlah</th>
                    <th style="width: 8%;">Harga</th>
                    <th style="width: 8%;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($data as $d) {
                    $total += $d->qty * $d->harga_modal;
                ?>
                    <tr>
                        <td><?php echo $d->kode_barang; ?></td>
                        <td><?php echo $d->nama_barang; ?></td>
                        <td><?php echo $d->satuan; ?></td>
                        <td><?php echo $d->keterangan; ?></td>
                        <td><?php echo $d->exp_date; ?></td>
                        <td align="center"><?php echo number_format($d->qty); ?></td>
                        <td align="right"><?php echo number_format($d->harga_modal); ?></td>
                        <td align="right"><?php echo number_format($d->harga_modal * $d->qty); ?></td>
                    </tr>
                <?php } ?>
                <thead>
                    <tr>
                        <th colspan="7" style="text-align: center;">Total</th>
                        <th style="text-align:right"><?php echo number_format($total); ?></th>
                    </tr>
                </thead>
            </tbody>
        </table>
    </div>
    <br>
    <h5>Histori Pembayaran</h5>
    <div class="table-responsive mb-0">
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead id="datatable" style="background-color:#0085cd;color:white;">
                <tr>
                    <th style="width: 10%;">No Bukti</th>
                    <th style="width: 20%;">Tanggal Bayar</th>
                    <th>Keterangan</th>
                    <th style="text-align:right;width:15%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($bayar as $d) {
                    $total += $d->jumlah;
                ?>
                    <tr>
                        <td><?php echo $d->nobukti; ?></td>
                        <td><?php echo $d->tgl_bayar; ?></td>
                        <td><?php echo $d->keterangan; ?></td>
                        <td align="right"><?php echo number_format($d->jumlah); ?></td>
                    </tr>
                <?php } ?>
                <thead>
                    <tr>
                        <th colspan="3" style="text-align: center;">Total</th>
                        <th style="text-align:right"><?php echo number_format($total); ?></th>
                    </tr>
                </thead>
            </tbody>
        </table>
    </div>
</div>