<form class="form-load" type="update" action="{{ route('admin.couriers.update', $courier->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ $courier->name }}" required>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Client ID</label>
                <input type="text" class="form-control" name="client_id" value="{{ $courier->client_id }}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Secret ID</label>
                <input type="text" class="form-control" name="secret_id" value="{{ $courier->secret_id }}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>API Key</label>
                <input type="text" class="form-control" name="api_key" value="{{ $courier->api_key }}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>API URL</label>
                <input type="text" class="form-control" name="api_url" value="{{ $courier->api_url }}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="1" @if($courier->status==1) selected @endif>Active</option>
                    <option value="0" @if($courier->status==0) selected @endif>Inactive</option>
                </select>
            </div>
        </div>
    </div>
    <x-admin.modal.update-btn />
</form>
