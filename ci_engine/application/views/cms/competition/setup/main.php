<div class="well well-sm">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="name">Competition Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($competition->name)?$competition->name :''; ?>" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="title">Competition Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($competition->title)?$competition->title:''; ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="template">Template Name</label>
                <input type="text" class="form-control" id="template" name="template" value="<?php echo isset($competition->template) ? $competition->template :''; ?>" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="active">Active Competition</label>
                <select id="active" name="active" class="form-control">
                    <option value="0" <?php echo isset($competition->active)&&$competition->active==0 ? '':'selected'; ?>>Not Active</option>
                    <option value="1" <?php echo isset($competition->active)&&$competition->active==1 ? 'selected':''; ?>>Active</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="current_stage">Current Stage</label>
                <input type="number" class="form-control" id="current_stage" name="current_stage" min="0" step="1" value="<?php echo isset($competition->current_stage)?$competition->current_stage:0; ?>" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="total_stage">Total Stage</label>
                <input type="number" class="form-control" id="total_stage" name="total_stage" min="1" step="1" value="<?php echo isset($competition->total_stage)?$competition->total_stage:1; ?>" />
            </div>
        </div>
    </div>
</div>