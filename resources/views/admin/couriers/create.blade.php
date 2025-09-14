<form class="form-load" type="create" action="{{ route('admin.couriers.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="required">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Courier Name" required>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Client ID</label>
                <input type="text" class="form-control" name="client_id">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Secret ID</label>
                <input type="text" class="form-control" name="secret_id">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>API Key</label>
                <input type="text" class="form-control" name="api_key">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>API URL</label>
                <input type="text" class="form-control" name="api_url">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
    </div>
    <x-admin.modal.create-btn />
</form>
