<div class="main-content">
    <div class="container-fluid">
        <!-- OVERVIEW -->
        <div id="exTab2" >
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
            <ul class="nav nav-tabs package-tabs">
                <li class="active">
                    <a href="#1" data-toggle="tab">Current shipments</a>
                </li>
                <!--<li>
                    <a href="#2" data-toggle="tab">Archive</a>
                </li>-->
                <li>
                    <a href="#3" data-toggle="tab"><i class="fa fa-plus-square" aria-hidden="true"></i> Add new</a>
                </li>
                <div class="pull-right order-dep">
                    <form id="order">
                        <label for="sel1">Department:</label>
                        <select class="form-control " name="dep" id="deps" onchange="$('#order').submit()">
                            <option value="0">All</option>

                            <?php foreach($data['deps'] as $dep) : ?>
                                <option value="<?=$dep->id?>"><?=$dep->name?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
            </ul>


            <div class="tab-content ">

                <div class="tab-pane active" id="1">
                    <!-- OVERVIEW -->
                    <div class="panel panel-headline package-panel">

                        <div class="panel-body ">

                            <div class="row">
                                <table id="departments" class="table  table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Description</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th style=" width: 25%;text-align: center;">Actions</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php foreach($data['packs'] as $pack) : ?>
                                        <tr id="pack-<?=$pack->id?>">
                                            <td class="pack-title"><?=$pack->title?></td>
                                            <td class="pack-from"><?=$pack->from_address?></td>
                                            <td class="pack-to"><?=$pack->to_address?></td>
                                            <td class="pack-description"><?=$pack->description?></td>
                                            <td class="pack-dep" data-dep-id="<?=$pack->dep_id?>"><?=$pack->dep_name?></td>
                                            <td class="pack-status" style="text-align: center; position:relative;">
                                                <div id="status-loader" class="preloader text-center hide-alert loader-<?=$pack->id?>">
                                                    <div id="preloader_1">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                </div>
                                                <select class="form-control" name="stats" id="status-<?=$pack->id?>" style="width: 100%; text-align:center;" onchange="changeStatus(<?=$pack->id?>)" >
                                                    <?php
                                                        $tmp = [
                                                            'sent',
                                                            'completed',
                                                            'pending'
                                                        ];

                                                        $stats =  [];

                                                        $stats[0] = $pack->status;

                                                        foreach ($tmp as $stat) {
                                                            if ($stat == $pack->status) continue;
                                                            $stats[] = $stat;
                                                        }

                                                        foreach ($stats as $stat) {
                                                            echo '<option value="' . $stat . '">' . $stat . '</option>';
                                                        }
                                                    ?>

                                                </select>
                                            </td>

                                            <td style="text-align: center;">
                                                <button type="button" class="btn btn-primary" onclick="showEditPack(<?=$pack->id?>)"><i class="lnr lnr-pencil"></i> Edit</button>
                                                <!-- <button type="button" class="btn btn-info" onclick="showEditPack(<?=$pack->id?>)"><i class="fa fa-archive"></i> To Archive</button>-->
                                                <button type="button" class="btn btn-danger" onclick="showDeletePack(<?=$pack->id?>)"><i class="fa fa-trash-o"></i> Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane " id="2">
                    <!-- OVERVIEW -->
                    <div class="panel panel-headline package-panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">List of Department 2s</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div>
                                    <h3>Standard tab panel created on bootstrap using nav-tabs</h3>
                                </div>
                                <div >
                                    <h3>Notice the gap between the content and tab after applying a background color</h3>
                                </div>
                                <div >
                                    <h3>add clearfix to tab-content (see the css)</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane " id="3">
                    <!-- OVERVIEW -->
                    <div class="panel panel-headline package-panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Add new package </h3>
                        </div>
                        <div class="panel-body">
                            <div id="create-loader" class="preloader text-center hide-alert">
                                <div id="preloader_1">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                            <div id="create-form" class="row col-md-8 col-md-offset-2" >
                                <div id="err-alert" class="alert alert-danger hide-alert">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    <span id="err-msg">

                                    </span>
                                </div>
                                <div id="succ-alert" class="alert alert-success hide-alert">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    <span id="succ-msg">
                                        The package was successfully added
                                    </span>
                                </div>
                                <form action="/package/create" method="POST"  id="pack-new">
                                    <div class="form-group">
                                        <label for="name">Title:</label>
                                        <input type="text" class="form-control" id="name" name="title" value="<?=$_SESSION['name']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">From:</label>
                                        <input type="text" class="form-control" id="address" name="from" value="<?=$_SESSION['address']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">To:</label>
                                        <input type="text" class="form-control" id="phone" name="to" value="<?=$_SESSION['phone']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Description:</label>
                                        <textarea id="description" class="form-control" name="description" style="resize: vertical;height:160px;"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="sel1">Department:</label>
                                        <select class="form-control" name="dep_id" id="deps">
                                            <?php foreach($data['deps'] as $dep) : ?>
                                                <option value="<?=$dep->id?>"><?=$dep->name?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button id="create-btn" class="btn btn-success pull-right btn-add"><i class="fa fa-plus-square" aria-hidden="true"></i> Add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "_edit.php" ?>
<?php include "_delete.php" ?>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>
<script src="/js/package.js"></script>
<script>
    $(document).ready(function() {
        var dep_id = <?=$_GET['dep']?>;
        if (dep_id)$("#deps").val(dep_id);
        $('#departments').DataTable();
    });
</script>