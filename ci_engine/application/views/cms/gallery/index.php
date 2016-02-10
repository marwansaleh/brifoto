<input type="hidden" id="selected_competition_id" value="<?php echo $competition_id; ?>" />
<input type="hidden" id="selected_competition_stage" value="<?php echo $competition_stage; ?>" />

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading"><!-- button tool bar -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="pull-left">
                                <form class="form-inline" id="form-filter" role="form" method="POST">
                                    <select class="form-control input-sm" id="competition_id" name="competition_id">
                                        <option value="0">--All competitions--</option>
                                        <?php foreach ($competitions as $comp): ?>
                                            <option value="<?php echo $comp->id; ?>" <?php echo $comp->id == $competition_id ? 'selected' : ''; ?>><?php echo $comp->title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select class="form-control input-sm" id="competition_stage" name="competition_stage">
                                        <option value="0">--All stages--</option>
                                    </select>
                                    <input type="number" class="form-control input-sm" id="rec_per_page" name="rec_per_page" value="<?php echo $rec_per_page ?>" min="1" step="1" />
                                    <button class="btn btn-primary btn-sm" id="btn-filter" type="button"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                                </form>
                            </div>
                            <div class="pull-right">
                                <div class="btn-toolbar" role="toolbar">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-danger" id="btn-delete-selected" disabled="true"><span class="glyphicon glyphicon-remove-circle"></span> Delete Selected</button>
                                        <button type="button" class="btn btn-default" id="btn-download-selected" disabled="true"><span class="glyphicon glyphicon-download"></span> Download Images</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="panel-body" id="main-image-container"><!-- Data table -->
                    <!-- filled up by ajax -->
                </div>
                <div class="panel-footer"><!-- pagination -->
                    <div id="pagination"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Photo Attributes</h4>
                </div>
                <div class="panel-body">
                    <a id="image-single-fancy"><img id="attr-image-selected" src="" class="img-responsive" /></a>
                    <table class="table table-striped">
                        <tr>
                            <td>Title</td>
                            <td id="attr-title"></td>
                        </tr>
                        <tr>
                            <td>Competition</td>
                            <td id="attr-competition"></td>
                        </tr>
                        <tr>
                            <td>Member</td>
                            <td id="attr-member"></td>
                        </tr>
                        <tr>
                            <td>Upload</td>
                            <td id="attr-upload-date"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table class="table" id="attr-nominee">
                                    <thead>
                                        <tr>
                                            <th>Stage</th>
                                            <th>Score</th>
                                            <th>Rank</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="well well-sm">
                        <form role="form" class="form-inline">
                            <legend>Promote / Demote</legend>
                            <div class="form-group form-group-sm">
                                <input type="number" class="form-control input-sm promote-control" min="0" max="1000" step="1" id="promote-score" placeholder="Score">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="number" class="form-control input-sm promote-control" min="0" max="1000" step="1" id="promote-rank" placeholder="Rank">
                            </div>
                            
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <button type="button" class="btn btn-primary btn-sm promote-control" id="submit-promote"><span class="glyphicon glyphicon-arrow-up"></span> Promote</button>
                                <button type="button" class="btn btn-warning btn-sm demote-control" id="submit-demote">Demote <span class="glyphicon glyphicon-arrow-down"></span></button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="well well-sm">
                        <div class="center-block">
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <button type="button" class="btn btn-success" id="btn-download-active-image"><span class="glyphicon glyphicon-download"></span> Download</button>
                                <button type="button" class="btn btn-danger" id="btn-delete-active-image"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var GalleryManager = {
        competitionID : 0,
        competitionStage : 0,
        displayNum : 20,
        currentPage : 1,
        totalPages: 1,
        activeImageID : 0,
        activeImage : {},
        images : [],
        init : function (id, stage, num){
            this.competitionID = id!=undefined ? parseInt(id) : 0;
            this.competitionStage = stage!=undefined ? parseInt(stage) : 0;
            this.displayNum = num!=undefined ? parseInt(num) : 20;
            this.loadStage();
        },
        setCompetition: function (competitionID){
            this.competitionID = parseInt(competitionID);
        },
        setStage : function (stage){
            this.competitionStage = parseInt(stage);
        },
        setDisplayNumber : function (displayNum){
            this.displayNum = displayNum!=undefined ? parseInt(displayNum):20;
        },
        loadStage : function (){
            var _this = this;
            _this.competitionStage = 0;
            $('#competition_stage').empty();
            
            $.getJSON('<?php echo site_url('cms/gallery/get_competition_stage'); ?>/'+ this.competitionID, function (data){
                $('#competition_stage').append('<option value="0">--All stages--</option>');
                for (var i=1; i<=parseInt(data.total_stage); i++){
                    var s = '<option value="'+i+'"'+ (_this.competitionStage==i?' selected':'')+'>Stage '+ i+'</option>';
                    $('#competition_stage').append(s);
                }
            });
        },
        downloadActiveImage : function (){
            var wnd = window.open("<?php echo site_url('cms/gallery/image_download'); ?>/"+this.activeImageID);
        },
        downloadSelectedImages : function (arrImageIDs){
            var wnd = window.open("<?php echo site_url('cms/gallery/images_download'); ?>/"+arrImageIDs.join('-'));
        },
        deleteActiveImage : function (){
            var _this = this;
            
            $.getJSON("<?php echo site_url('cms/gallery/image_delete'); ?>/"+_this.activeImageID, function(data){
                if (data.success){
                    _this.loadImages(_this.currentPage);
                }else{
                    alert(data.message);
                }
            });
        },
        deleteImages: function (arrImageIDs){
            var _this = this;
            
            $.getJSON("<?php echo site_url('cms/gallery/images_delete'); ?>",{list_id:arrImageIDs.join()}, function(data){
                if (data.success){
                    _this.loadImages(_this.currentPage);
                }else{
                    alert(data.message);
                }
            });
        },
        loadImages: function (page){
            var _this = this;
            var pageRequest = page!=undefined?page:_this.currentPage;
            
            _this.currentPage = pageRequest;
            
            $.getJSON("<?php echo site_url('cms/gallery/load_images'); ?>", 
            {
                competitionID: _this.competitionID, 
                stage: _this.competitionStage, 
                num: _this.displayNum,
                page: pageRequest
            }, function (data){
                _this.images = []; //reset images caches
                $('#main-image-container').empty();
                
                _this.totalPages = parseInt(data.paging.totalPages);
                
                if (data.paging.totalRecords > 0){
                    for (var i in data.items){
                        var s = '<div class="image-item-container">';
                        s+= '<input type="checkbox" class="image-checkbox" value="'+data.items[i].id+'" />';
                        s+= '<a href="#">';
                        s+= '<img class="img-responsive image-list-item" src="'+data.items[i].image_url+'" />';
                        s+= '</a>';
                        //s+= '<div class="btn-group image-button-actions">';
                        //s+= '<button class="btn btn-xs btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        //s+= '<span class="glyphicon glyphicon-cog"></span>';
                        //s+= '</button>';
                        //s+= '<ul class="dropdown-menu">';
                        //s+= '<li><a href="#">Attributes</a></li>';
                        //s+= '<li><a href="#">Go next stage</a></li>';
                        //s+= '<li role="separator" class="divider"></li>';
                        //s+= '<li><a href="#">Delete</a></li>';
                        //s+= '</ul>';
                        //s+= '</div>'
                        s+= '</div>';
                        
                        $('#main-image-container').append(s);
                        //add image records to caches
                        _this.images.push(data.items[i]);
                    }
                    
                    //show first image loaded
                    _this.loadImageAttribute(_this.images[0].id);
                }
                
                _this._drawPaging();
            });
        },
        prev: function (){
            if (this.currentPage > 1){
                this.currentPage = this.currentPage - 1;
            }
        },
        next: function (){
            if (this.currentPage < this.totalPages){
                this.currentPage = this.currentPage + 1;
            }
        },
        _drawPaging: function (){
            var s = '<nav><ul class="pager">';
            if (this.currentPage > 1){
                s+= '<li><a href="javascript:previousPage();">Previous</a></li>';
            }else{
                s+= '<li class="disabled"><a href="#">Previous</a></li>';
            }
            s+= '<li> Page: '+this.currentPage+' / '+ this.totalPages+' </li>'
            if (this.currentPage < this.totalPages){
                s+= '<li><a href="javascript:nextPage();">Next</a></li>';
            }else{
                s+= '<li class="disabled"><a href="#">Next</a></li>';
            }
            s+= '</ul></nav>';
            
            $('#pagination').html(s);
        },
        loadImageAttribute : function (imageID){
            var _this = this;
            
            $.getJSON("<?php echo site_url('cms/gallery/load_nominee_attribute'); ?>/"+imageID,function (data){
                if (data.success){
                    $('#image-single-fancy').attr('href', data.nominee.image_url).attr('title', data.nominee.upload.description);
                    $('#attr-image-selected').attr('src', data.nominee.image_url);
                    $('td#attr-title').text(data.nominee.upload.description);
                    $('td#attr-competition').text(data.nominee.competition.title + ' ('+data.nominee.competition.status+')');
                    $('td#attr-member').text(data.nominee.member.nama);
                    $('td#attr-upload-date').text(data.nominee.upload.datetime);
                    
                    $('table#attr-nominee tbody').empty();
                    for (var i in data.nominee.nominee){
                        var n = '<tr>';
                        n+= '<td>'+data.nominee.nominee[i].stage+'</td>';
                        n+= '<td>'+data.nominee.nominee[i].score+'</td>';
                        n+= '<td>'+data.nominee.nominee[i].rank+'</td>';
                        n+= '</tr>';
                        
                        $('table#attr-nominee tbody').prepend(n);
                    }
                    
                    $('.promote-control').prop('disabled', !data.nominee.promote_enabled);
                    $('.demote-control').prop('disabled', !data.nominee.demote_enabled);
                    
                    _this.activeImageID = imageID;
                    _this.activeImage = data.nominee;
                }else{
                    alert(data.message);
                }
            });
        },
        imagePromote : function (score, rank){
            var _this = this;
            
            score = score!=undefined ? parseInt(score) : 0;
            rank = rank != undefined ? parseInt(rank) : 0;
            
            $.getJSON("<?php echo site_url('cms/gallery/promote'); ?>",{
                image_id:_this.activeImageID, 
                stage: _this.activeImage.promote_stage, 
                comp_id:_this.activeImage.comp_id,
                score: score,
                rank : rank
            }, function(data){
                if (data.success){
                    _this.loadImageAttribute(_this.activeImageID);
                }else{
                    alert(data.message);
                }
            });
        },
        imageDemote : function (){
            var _this = this;
            
            $.getJSON("<?php echo site_url('cms/gallery/demote'); ?>",{image_id:_this.activeImageID, stage: _this.activeImage.current_stage, comp_id:_this.activeImage.comp_id}, function(data){
                if (data.success){
                    _this.loadImageAttribute(_this.activeImageID);
                }else{
                    alert(data.message);
                }
            });
        },
        onCheckBoxChecked : function (){
            
        }
    };
    
    function previousPage(){
        GalleryManager.prev();
        GalleryManager.loadImages();
    }
    function nextPage(){
        GalleryManager.next();
        GalleryManager.loadImages();
    }
    
    $(document).ready(function(){
        
        //init gallery manager
        GalleryManager.init($('#competition_id').val(), $('#selected_competition_stage').val());
        //load images
        GalleryManager.loadImages(1);
        
        $('#btn-filter').on('click', function(){
            GalleryManager.loadImages(1);
        });
        
        $('#competition_id').on('change', function (){
            GalleryManager.setCompetition($(this).val());
            GalleryManager.loadStage();
        });
        
        $('#competition_stage').on('change', function(){
            GalleryManager.setStage($(this).val());
        });
        
        $('#rec_per_page').on('change', function (){
            GalleryManager.setDisplayNumber($(this).val());
        });
        
        //$('.image-select').on('click', function(){alert('tes');});
        $('#main-image-container').on('click','.image-item-container', function(){
            var image_id = $(this).find('input.image-checkbox').val();
            GalleryManager.loadImageAttribute(image_id);
        });
        
        $('#image-single-fancy').fancybox();
        
        $('#submit-promote').on('click', function(){
            GalleryManager.imagePromote($('#promote-score').val(), $('#promote-rank').val());
        });
        
        $('#submit-demote').on('click', function(){
            GalleryManager.imageDemote()
        });
        
        $('#btn-download-active-image').on('click', function (){
            GalleryManager.downloadActiveImage();
        });
        
        $('#btn-delete-active-image').on('click', function (){
            if (confirm('Delete this active image from database ? All records of this image will be deleted too')){
                GalleryManager.deleteActiveImage();
            }
        });
        
        $('#btn-download-selected').on('click', function (){
            var selected = [];
        
            $('.image-checkbox:checked').each(function (){
                selected.push($(this).val());
            });

            if (selected.length > 0){
                GalleryManager.downloadSelectedImages(selected);
            }else{
                alert('No images selected to download');
            }
        });
        
        $('#btn-delete-selected').on('click', function(){
            if (confirm('Delete selected images ?')){
                var selected = [];
        
                $('.image-checkbox:checked').each(function (){
                    selected.push($(this).val());
                });
                
                if (selected.length > 0){
                    GalleryManager.deleteImages(selected);
                }else{
                    alert('No images selected to delete');
                }
            }
        });
        
        $('#main-image-container').on('click', '.image-checkbox', function (){
            $(this).parent().toggleClass('image-item-container-selected');
            
            $('#btn-delete-selected').prop('disabled', $('.image-checkbox:checked').length==0);
            $('#btn-download-selected').prop('disabled', $('.image-checkbox:checked').length==0);
        });
    });
    
</script>