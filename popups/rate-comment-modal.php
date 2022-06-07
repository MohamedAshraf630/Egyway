<!-- ## DISABLE MODAL ## -->
<div class="modal fade" id="rateCommentModal" tabindex="-1" aria-labelledby="rateCommentModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="services/orders/rate-comment-service.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="rateCommentModal">Rate your order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="orderId" name="orderId" value="" />
                    <div class="form-group">
                        <label>Rate:</label>
                        <label class="mr-2">
                            <input required type="radio" id="rate" name="rate" value="1" />
                            1
                        </label>
                        <label class="mr-2">
                            <input required type="radio" id="rate" name="rate" value="2" />
                            2
                        </label>
                        <label class="mr-2">
                            <input required type="radio" id="rate" name="rate" value="3" />
                            3
                        </label>
                        <label class="mr-2">
                            <input required type="radio" id="rate" name="rate" value="4" />
                            4
                        </label>
                        <label class="mr-2">
                            <input required type="radio" id="rate" name="rate" value="5" />
                            5
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea required class="w-100" id="comment" name="comment" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit Rating</button>
                </div>
            </form>
        </div>
    </div>
</div>