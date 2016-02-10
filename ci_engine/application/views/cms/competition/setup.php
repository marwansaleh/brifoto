<!-- panel edit -->
<div class="container-fluid">
    <div class="well well-lg">
        <form role="form" method="post" action="<?php echo $submit_url; ?>">
            <input type="hidden" name="competition_id" value="<?php echo isset($competition->id) ? $competition->id : 0; ?>" />
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Competition</a></li>
                <li role="presentation"><a href="#parameters" aria-controls="parameters" role="tab" data-toggle="tab">Parameters</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="main">
                    <?php $this->load->view('cms/competition/setup/main'); ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="parameters">
                    <?php $this->load->view('cms/competition/setup/params'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary btn-large"><span class="glyphicon glyphicon-save"></span> Submit</button>
                        <button type="reset" class="btn btn-default btn-large"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                        <a class="btn btn-default btn-large" href="<?php echo $back_url; ?>"><span class="glyphicon glyphicon-backward"></span> Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>