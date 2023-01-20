<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <form method="post" id="sample_form" class="form-horizontal">
        @csrf
        @method('DELETE')
        <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">Confirmation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
        </div>
    </form>
    </div>
    </div>
</div>
