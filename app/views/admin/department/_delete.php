<!-- Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Department - <strong class="rm-dep-name"></strong></h4>
            </div>
            <form action="/department/delete" method="POST">
                <div class="modal-body">
                    <p style="text-align: center">
                        Are you sure you want to delete the department <strong class="rm-dep-name"></strong> ?
                    </p>
                    <input id="rm-dep-id" hidden name="id"/>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger create-btn"><i class="fa fa-trash-o"></i> Delete</button>
                </div>
            </form>
        </div>

    </div>
</div>