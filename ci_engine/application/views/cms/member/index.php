<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading"><!-- button tool bar -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-default" href="<?php echo site_url('cms/member/edit?page='.$page); ?>"><span class="glyphicon glyphicon-plus"></span> Create</a>
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
                        <th>Nama</th>
                        <th>Pernonal Number</th>
                        <th>Unit Kerja</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th class="text-right">Jumlah Foto</th>
                        <th class="text-center">Registered</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($items as $item): ?>
                    <tr>
                        <td><?php echo ($offset+$i++); ?></td>
                        <td><?php echo $item->nama; ?></td>
                        <td><?php echo $item->pn; ?></td>
                        <td><?php echo $item->unit; ?></td>
                        <td><?php echo $item->hp; ?></td>
                        <td><?php echo $item->email; ?></td>
                        <td class="text-right"><?php echo number_format($item->upload_count,0,'.',','); ?></td>
                        <td><?php echo date('d-M-Y', $item->reg_time); ?></td>
                        <td class="text-center">
                            <a href="<?php echo site_url('cms/member/edit?id='.$item->id.'&page='.$page); ?>" class="btn btn-sm btn-info" title="Edit member"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a href="<?php echo site_url('cms/member/delete?id='.$item->id.'&page='.$page); ?>" class="btn btn-sm btn-warning confirmation" title="Delete item"><span class="glyphicon glyphicon-remove"></span></a>
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