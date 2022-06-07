<!-- ## DISABLE MODAL ## -->
<div class="modal fade" id="disableModal" tabindex="-1" aria-labelledby="disableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disableModalLabel">Are you sure you want to disable this user ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="disableUserId" value="" />
                <label>Disable Comment</label>
                <textarea class="w-100" id="disableUserComment" rows="4"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button onclick="handleSaveChanges()" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>