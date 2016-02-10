        <div class="container-fluid">
            <hr>
            <footer>
                <div class="container-fluid">
                    <p class="text-center">&copy;BRIFotograferClub</p>
                </div>
            </footer>
        </div>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo site_url(config_item('library').'bootstrap/js/bootstrap.min.js'); ?>"></script>
        <!-- JQuery Form -->
        <script src="<?php echo site_url(config_item('library').'jquery-form/jquery.form.min.js') ?>"></script>
        
        <!-- Nano gallery -->
        <script src="<?php echo site_url(config_item('library').'nanogallery/jquery.nanogallery.min.js') ?>"></script>
        <!-- fancybox -->
        <script src="<?php echo site_url(config_item('library').'fancybox/jquery.fancybox.pack.js') ?>"></script>
        
        <!-- bootstrap-datetimepicker -->
        <script src="<?php echo site_url(config_item('library').'moment/moment.js') ?>"></script>
        <script src="<?php echo site_url(config_item('library').'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.hastooltip').tooltip();
                $('.confirmation').on('click',function(){
                    var text = $(this).attr('title')!=''?$(this).attr('title'):'Are you sure?';
                    if (!confirm(text)){
                        return false;
                    }
                });
                $(".fancybox").fancybox({
                    padding : 0,
                    openEffect	: 'elastic',
                    helpers:  {
                        title : {
                            type : 'over',
                            position: 'top'
                        },
                        overlay : {
                            showEarly : false
                        }
                    }
                });
            });
        </script>
    </body>
</html>