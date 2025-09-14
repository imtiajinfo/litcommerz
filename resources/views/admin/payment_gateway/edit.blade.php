<form class="form-load" type="update" action="{{ route('admin.paymentGateways.update', $gateway->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" value="{{ $gateway->name }}" placeholder="Gateway Name" required>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Mode<span class="text-danger">*</span></label>
                <select class="form-control" name="mode" required>
                    <option value="sandbox" @if($gateway->mode=='sandbox') selected @endif>Sandbox</option>
                    <option value="live" @if($gateway->mode=='live') selected @endif>Live</option>
                </select>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Client ID<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="client_id" value="{{ $gateway->client_id }}" placeholder="Client ID" required>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Secret ID<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="secret_id" value="{{ $gateway->secret_id }}" placeholder="Secret ID" required>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Merchant ID</label>
                <input type="text" class="form-control" name="merchant_id" value="{{ $gateway->merchant_id }}" placeholder="Merchant ID" required>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" required>
                    <option value="1" @if($gateway->status==1) selected @endif>Active</option>
                    <option value="0" @if($gateway->status==0) selected @endif>Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <x-admin.modal.update-btn />
</form>