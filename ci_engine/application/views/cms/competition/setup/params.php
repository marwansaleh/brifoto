<input type="hidden" name="competition_param_id" value="<?php echo $params->id; ?>" />
<div class="well well-sm">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="max_file_size">MAX_FILE_SIZE</label>
                <input type="number" class="form-control" id="max_file_size" name="max_file_size" value="<?php echo $params->max_file_size; ?>" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="min_file_size">MIN_FILE_SIZE</label>
                <input type="number" class="form-control" id="min_file_size" name="min_file_size" value="<?php echo $params->min_file_size; ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="allowed_extensions">ALLOWED_EXTENSIONS</label>
                <input type="text" class="form-control" id="allowed_extensions" name="allowed_extensions" value="<?php echo $params->allowed_extensions; ?>" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="max_image_width">MAX_IMAGE_WIDTH</label>
                <input type="number" class="form-control" id="max_image_width" name="max_image_width" value="<?php echo $params->max_image_width; ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="min_image_width">MIN_IMAGE_WIDTH</label>
                <input type="number" class="form-control" id="min_image_width" name="min_image_width" value="<?php echo $params->min_image_width; ?>" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="max_image_height">MAX_IMAGE_HEIGHT</label>
                <input type="number" class="form-control" id="max_image_height" name="max_image_height" value="<?php echo $params->max_image_height; ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="min_image_height">MIN_IMAGE_HEIGHT</label>
                <input type="number" class="form-control" id="min_image_height" name="min_image_height" value="<?php echo $params->min_image_height; ?>" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="max_upload">MAX_UPLOAD</label>
                <input type="number" class="form-control" id="max_upload" name="max_upload" value="<?php echo $params->max_upload; ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="upload_start">UPLOAD_START</label>
                <div class="input-group datetimepicker col-sm-12">
                    <input type="text" class="form-control" id="upload_start" name="upload_start" data-date-format="YYYY-MM-DD hh:mm:ss" value="<?php echo $params->upload_start; ?>" placeholder="Selesai">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="upload_end">UPLOAD_END</label>
                <div class="input-group datetimepicker col-sm-12">
                    <input type="text" class="form-control" id="upload_end" name="upload_end" data-date-format="YYYY-MM-DD hh:mm:ss" value="<?php echo $params->upload_end; ?>" placeholder="Selesai">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="upload_path">UPLOAD_PATH</label>
                <input type="text" class="form-control" id="upload_path" name="upload_path" value="<?php echo $params->upload_path; ?>" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="filename_element_count">FILENAME_ELEMENT</label>
                <input type="text" class="form-control" id="filename_element_count" name="filename_element_count" value="<?php echo $params->filename_element_count; ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group form-group-lg">
                <label for="create_thumbnail">CREATE_THUMBNAIL</label>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default <?php echo $params->create_thumbnail == 1 ? 'active' : ''; ?>">
                        <input type="radio" name="create_thumbnail" value="1" <?php echo $params->create_thumbnail == 1 ? 'checked="checked"' : ''; ?>> YES
                    </label>
                    <label class="btn btn-default <?php echo $params->create_thumbnail == 0 ? 'active' : ''; ?>">
                        <input type="radio" name="create_thumbnail" value="0" <?php echo $params->create_thumbnail == 0 ? 'checked="checked"' : ''; ?>> NO
                    </label>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.datetimepicker').datetimepicker();
    });
</script>