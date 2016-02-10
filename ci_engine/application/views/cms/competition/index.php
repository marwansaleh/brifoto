<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading"><!-- button tool bar -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-default" href="<?php echo site_url(config_item('ctl_cms_comp').'setup?page='.$page); ?>"><span class="glyphicon glyphicon-plus"></span> Create</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="pull-right">
                        <form role="form" method="post">
                            <input type="hidden" name="is_searching" value="1" />
                            <div class="input-group input-group-sm">
                                <input class="form-control" type="text" id="search" name="search" value="<?php echo $search_text; ?>" placeholder="Search" />
                                <div class="input-group-btn">
                                    <button class="btn <?php echo $is_searching?'btn-success':'btn-primary';?>" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body"><!-- Data table -->
            <table id="data-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Kompetisi</th>
                        <th>Nama Pendek</th>
                        <th class="text-right">Jumlah Foto</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($items as $item): ?>
                    <tr>
                        <td><?php echo ($offset+$i++); ?></td>
                        <td><?php echo $item->title; ?></td>
                        <td><?php echo $item->name; ?></td>
                        <td class="text-right"><?php echo number_format($item->upload_count,0,'.',','); ?></td>
                        <td class="text-center">
                            <?php if ($item->active==1): ?>
                            <a href="<?php echo site_url('cms/comp/setactive?id='.$item->id.'&page='.$page.'&active=0'); ?>" class="btn btn-sm btn-success" title="Set inactive"><span class="glyphicon glyphicon-check"></span></a>
                            <?php else: ?>
                            <a href="<?php echo site_url('cms/comp/setactive?id='.$item->id.'&page='.$page.'&active=1'); ?>" class="btn btn-sm btn-warning" title="Set active"><span class="glyphicon glyphicon-remove-sign"></span></a>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo site_url('cms/comp/setup?id='.$item->id.'&page='.$page); ?>" class="btn btn-sm btn-info" title="Setup parameter"><span class="glyphicon glyphicon-th-large"></span></a>
                            <a href="<?php echo site_url('cms/comp/delete?id='.$item->id.'&page='.$page); ?>" class="btn btn-sm btn-warning confirmation" title="Delete item"><span class="glyphicon glyphicon-remove"></span></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer"><!-- pagination -->
            <?php echo $pagination; ?>
        </div>
    </div>
</div>