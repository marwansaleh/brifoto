<!-- panel edit -->
<div class="container-fluid">
    <form role="form" method="post" action="<?php echo $submit_url; ?>">
        <div class="form-group form-group-lg">
            <label for="name">Nama Peserta</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($item->nama)?$item->nama :''; ?>" />
        </div>
        <div class="form-group form-group-lg">
            <label for="pn">Nomor Personal</label>
            <input type="text" class="form-control" id="pn" name="pn" value="<?php echo isset($item->pn)?$item->pn :''; ?>" />
        </div>
        <div class="form-group form-group-lg">
            <label for="unit">Unit Kerja</label>
            <input type="text" class="form-control" id="unit" name="unit" value="<?php echo isset($item->unit)?$item->unit :''; ?>" />
        </div>
        <div class="form-group form-group-lg">
            <label for="hp">Nomor HP</label>
            <input type="text" class="form-control" id="hp" name="hp" value="<?php echo isset($item->hp)?$item->hp :''; ?>" />
        </div>
        <div class="form-group form-group-lg">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($item->email)?$item->email :''; ?>" />
        </div>
        <div class="form-group form-group-lg">
            <button type="submit" class="btn btn-primary btn-large"><span class="glyphicon glyphicon-save"></span> Submit</button>
            <button type="reset" class="btn btn-default btn-large"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
            <a class="btn btn-default btn-large" href="<?php echo $back_url; ?>"><span class="glyphicon glyphicon-backward"></span> Cancel</a>
        </div>
    </form>
</div>