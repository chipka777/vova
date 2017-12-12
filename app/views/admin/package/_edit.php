<!-- Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Package <span class="edit-category-name"></span></h4>
            </div>
            <form action="/package/edit" method="POST"  id="pack-edit">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title-edit">Title:</label>
                        <input type="text" class="form-control" id="title-edit" name="title-e" value="<?=$_SESSION['name-e']?>">
                    </div>
                    <div class="form-group">
                        <label for="from-edit">From:</label>
                        <input type="text" class="form-control" id="from-edit" name="from-e" value="<?=$_SESSION['address-e']?>">
                    </div>
                    <div class="form-group">
                        <label for="to-edit">To:</label>
                        <input type="text" class="form-control" id="to-edit" name="to-e" value="<?=$_SESSION['phone-e']?>">
                    </div>
                    <div class="form-group">
                        <label for="description-edit">Description:</label>
                        <textarea id="description-edit" class="form-control" name="description-e" style="resize: vertical;height:160px;"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="sel1">Department:</label>
                        <select class="form-control" name="dep_id-e" id="deps-edit">
                            <?php foreach($data['deps'] as $dep) : ?>
                                <option value="<?=$dep->id?>"><?=$dep->name?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input id="id-edit" class="form-control" type="hidden" name="id" >
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default create-btn" >Save</button>
                </div>
            </form>
        </div>

    </div>
</div>