<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Cari Gambar Berdasarkan ID</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control" id="search_by" name="search_by">
                                <option value="id">ID</option>
                                <option value="name">Name</option>
                                <option value="pn">PN</option>
                                <option value="description">Title</option>
                            </select>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search_value" name="search_value" placeholder="Search.." />
                                    <div class="input-group-btn">
                                        <button type="button" value="Search" id="btn-search-image" class="btn btn-primary" data-loading-text="Loading...">Go</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="well well-sm" id="image-info">No image information</div>-->
                    <div class="panel-group" id="photo-list" role="tablist" aria-multiselectable="true">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-8">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Competition Active</h4>
                        </div>
                        <div class="panel-body">
                            <?php if ($competition): ?>
                            <table role="table" class="table table-striped">
                                <tr>
                                    <th>Title</th>
                                    <th>#Photo</th>
                                    <th>Is Final</th>
                                </tr>
                                <tr>
                                    <td><?php echo $competition->title; ?></td>
                                    <td><?php echo $competition->photo_count; ?></td>
                                    <td><?php echo $competition->final_stage==1 ? 'Final stage' :'Staging'; ?></td>
                                </tr>
                            </table>
                            <?php else:?>
                            <p>No active competition now</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Other Competitions</h4>
                        </div>
                        <div class="panel-body">
                            <?php if ($competitions): ?>
                            <table role="table" class="table table-striped">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>#Photo</th>
                                </tr>
                                <?php foreach ($competitions as $comp): ?>
                                <tr>
                                    <td>[<?php echo $comp->id; ?>]</td>
                                    <td><?php echo $comp->title; ?></td>
                                    <td><?php echo $comp->name; ?></td>
                                    <td><?php echo $comp->photo_count; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#search_value').on('keypress', function(e){
            if(e.which == 13) {
                $('#btn-search-image').click();
            }
        });
        $('#btn-search-image').on('click', function (){
            if ($('#search_value').val()){
                DashBoardManager.searchImage($('#search_by').val(), $('#search_value').val());
            }else{
                DashBoardManager._emptyPhotoContainer();
            }
        });
    });
    
    var DashBoardManager = {
        imageCollapseAccordionId: 'photo-list',
        setButtonStatus: function (status){
            $('#btn-search-image').button(status);
        },
        searchImage: function (search_by, search_value){
            var _this = this;
            _this.setButtonStatus('loading');
            _this._emptyPhotoContainer();
            
            $.getJSON('<?php echo site_url('cms/ajax/search_photos'); ?>',{search_by:search_by, search_value:search_value}, function (data){
                _this.setButtonStatus('reset');
                
                for (var i in data){
                    var head_id = 'heading_'+i;
                    var collapse_id = 'collapse_'+i;
                    var foto = '<div class="panel panel-default" id="panelphoto_'+data[i].id+'">';
                        foto+= '<div class="panel-heading" role="tab" id="'+head_id+'">';
                            foto+='<h4 class="panel-title">';
                                foto+= '<a role="button" data-toggle="collapse" data-parent="#'+_this.imageCollapseAccordionId+'" href="#'+collapse_id+'" aria-expanded="true" aria-controls="'+collapse_id+'">';
                                foto+= data[i].description; 
                                foto+= '</a>';
                            foto+= '</h4>';
                        foto+= '</div>';
                        foto+= '<div id="'+collapse_id+'" class="panel-collapse collapse'+(i==0?' in':'')+'" role="tabpanel" aria-labelledby="'+head_id+'">';
                            foto+= '<div class="panel-body">';
                                foto+= '<a class="fancybox" href="'+data[i].file_url+'" title="#'+data[i].id+': '+data[i].description+'">';
                                    foto+= '<img class="img-responsive" src="'+data[i].file_url+'" />';
                                foto+='</a>';
                                //create table info
                                foto+= '<table class="table table-stripped" role="table">';
                                foto+= '<tr>';
                                    foto+= '<td>Judul:</td>';
                                    foto+= '<td>#'+data[i].id+': '+data[i].description+'</td>';
                                foto+= '</tr>';
                                foto+= '<tr>';
                                    foto+= '<td>Kompetisi:</td>';
                                    foto+= '<td>'+data[i].competition+'</td>';
                                foto+= '</tr>';
                                foto+= '<tr>';
                                    foto+= '<td>Waktu Upload:</td>';
                                    foto+= '<td>'+data[i].upload_datetime+'</td>';
                                foto+= '</tr>';
                                foto+= '<tr>';
                                    foto+= '<td>Nama Peserta:</td>';
                                    foto+= '<td>'+data[i].member_name+'</td>';
                                foto+= '</tr>';
                                foto+= '<tr>';
                                    foto+= '<td>PN:</td>';
                                    foto+= '<td>'+data[i].member_pn+'</td>';
                                foto+= '</tr>';
                                foto+= '<tr>';
                                    foto+= '<td>Unit kerja:</td>';
                                    foto+= '<td>'+data[i].member_unit+'</td>';
                                foto+= '</tr>';
                                foto+= '<tr>';
                                    foto+= '<td>Nomor HP:</td>';
                                    foto+= '<td>'+data[i].member_hp+'</td>';
                                foto+= '</tr>';

                                foto+= '</table>';
                                foto+= '<a class="btn btn-default" target="_blank" href="'+data[i].download_url+'">Download</a>';
                                foto+= '<a class="btn btn-warning confirmation" href="javascript:deletePhoto('+data[i].id+')">Delete</a>';
                            foto+= '</div>';
                        foto+= '</div>';
                    foto+= '</div>';
                    
                    $('#'+_this.imageCollapseAccordionId).append(foto);
                }
            });
        },
        deletePhoto: function (id){
            $.getJSON('<?php echo site_url('cms/ajax/deletePhoto'); ?>/'+id, function (data){
                if (data.status == true){
                    $('#panelphoto_'+id).remove();
                }else{
                    alert(data.message);
                }
            });
        },
        _emptyPhotoContainer: function (){
            var _this = this;
            $('#'+_this.imageCollapseAccordionId).empty();
        }
    };
    
    function deletePhoto(id){
        if (confirm('Delete this photo ?')){
            DashBoardManager.deletePhoto(id);
        }
    }
</script>