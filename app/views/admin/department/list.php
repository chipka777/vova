<div class="main-content">
    <div class="container-fluid">
        <!-- OVERVIEW -->
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">List of Departments</h3>

            </div>
            <div class="panel-body">
                <div class="row">
                    <?php if(isset($_SESSION['error'])) : ?>
                        <div class="alert alert-danger">
                            <?=$_SESSION['error']?>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['succ'])) : ?>
                        <div class="alert alert-success">
                            <?=$_SESSION['succ']?>
                        </div>
                    <?php endif; ?>
                    <table id="departments" class="table  table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th style=" width: 20%;text-align: center;">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach($data['deps'] as $dep) : ?>
                        <tr id="dep-<?=$dep->id?>">
                            <td class="dep-name"><?=$dep->name?></td>
                            <td class="dep-addr"><?=$dep->address?></td>
                            <td class="dep-phone"><?=$dep->phone?></td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-primary" onclick="showEdit(<?=$dep->id?>)"><i class="lnr lnr-pencil"></i> Edit</button>
                                <button type="button" class="btn btn-danger" onclick="showDelete(<?=$dep->id?>)"><i class="fa fa-trash-o"></i> Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
<?php include "_edit.php" ?>
<?php include "_delete.php" ?>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="/js/list.js"></script>
<script>
    $(document).ready(function() {
        $('#departments').DataTable();
    } );
</script>
