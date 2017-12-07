<!-- Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Department <span class="edit-category-name"></span></h4>
            </div>
            <form action="/department/edit" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name-edit">Name</label>
                        <input id="name-edit" class="form-control" type="text" name="name" >
                    </div>
                    <div class="form-group">
                        <label for="name-edit">Address</label>
                        <input id="address-edit" class="form-control" type="text" name="address" >
                    </div>
                    <div class="form-group">
                        <label for="name-edit">Phone</label>
                        <input id="phone-edit" class="form-control" type="text" name="phone" >
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