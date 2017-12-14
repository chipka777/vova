<div class="main-content">
    <div class="container-fluid">
        <!-- OVERVIEW -->
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Packages </h3>

            </div>
            <div class="panel-body">
                <table id="departments" class="table  table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Description</th>
                        <th>Department</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach($data['packs'] as $pack) : ?>
                        <tr id="pack-<?=$pack->id?>">
                            <td class="pack-id"><?=$pack->id?></td>
                            <td class="pack-title"><?=$pack->title?></td>
                            <td class="pack-from"><?=$pack->from_address?></td>
                            <td class="pack-to"><?=$pack->to_address?></td>
                            <td class="pack-description"><?=$pack->description?></td>
                            <td class="pack-dep" data-dep-id="<?=$pack->dep_id?>"><?=$pack->dep_name?></td>
                            <td class="pack-status" ><?=$pack->status?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="/js/list.js"></script>
<script>
    $(document).ready(function() {
        $('#departments').DataTable();
    } );
</script>