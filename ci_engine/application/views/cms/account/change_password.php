<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo isset($page_title)?$page_title:'Change Password'; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo isset($message_box)?$message_box:''; ?>
                
                <form role="form" method="post">
                    <input type="hidden" name="submit_change" value="1" />
                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old password">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmation New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#myModal').modal();
        
        $('#myModal').on('hidden.bs.modal', function (e){
            window.location.href = "<?php echo site_url('cms/account/change_password/redirect/1'); ?>";
        });
    });
</script>