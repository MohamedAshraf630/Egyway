<!-- ## CANCEL ORDER MODAL ## -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="disableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disableModalLabel">Are you sure you want to cancel this order ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="userId" value="" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button onclick="handleConfirmClick()" type="button" class="btn btn-danger">Confirm</button>
            </div>
        </div>
    </div>
</div>