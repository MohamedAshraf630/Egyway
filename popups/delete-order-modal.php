<!-- ## DISABLE MODAL ## -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="disableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/egyway/services/orders/delete-order.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteOrderModalLabel">Are you sure you want to delete this order ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="orderId" id="orderId" value="" />
                    <label>Manager PIN</label>
                    <input class="form-control" name="managerPin" id="managerPin" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>