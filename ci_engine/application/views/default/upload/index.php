<div class="container">
    <form role="form" method="post" enctype="multipart/form-data" action="<?php echo $submit_url; ?>">
        <div class="well well-lg">
            <div class="form-group-lg">
                <label for="userfile">Unggah Foto</label>
                <div class="input-group">
                    <input type="file" class="form-control" id="userfile" name="userfile" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-upload"></span> Upload</button>
                    </span>
                </div>
                <p class="form-control-static">*JPG|JPEG, Maksimal 500Kb, 1024 x 700 piksel</p>
                <p class="form-control-static">
                    *Format nama file Nama_No.HP_Personal Number_Unit kerja_udul Foto.jpg
                    <strong>Contoh: Corleone_08138855XXX_12345_kanca cibadak_internet banking.jpg</strong>
                </p>
            </div>
        </div>
    </form>
</div>

<?php if (isset($items) && count($items)): ?>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Daftar Upload Oleh <?php echo $member->nama;  ?></h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Waktu Upload</th>
                        <th>Judul Foto</th>
                        <th>Dimensi</th>
                        <th>Size</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo date('d-M-Y H:i'); ?></td>
                        <td><?php echo $item->description; ?></td>
                        <td><?php echo $item->image_width ?> x <?php echo $item->image_height; ?> px</td>
                        <td><?php echo $item->file_size; ?>Kb</td>
                        <td>
                            <a class="btn btn-success btn-sm fancybox" href="<?php echo $item->image_url; ?>" title="<?php echo $item->description; ?>">
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; 
