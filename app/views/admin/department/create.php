<div class="main-content">
    <div class="container-fluid">
        <!-- OVERVIEW -->
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Adding a new department </h3>

            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
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
                        <form action="/department/create" method="POST">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?=$_SESSION['name']?>">
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?=$_SESSION['address']?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?=$_SESSION['phone']?>">
                            </div>
                            <button type="submit" class="btn btn-success pull-right btn-add"><i class="fa fa-plus-square" aria-hidden="true"></i> Add</button>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>