<form class="form-load" type="create" action="{{ route('admin.paymentGateways.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Gateway Name" required>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Mode<span class="text-danger">*</span></label>
                <select class="form-control" name="mode" required>
                    <option value="sandbox">Sandbox</option>
                    <option value="live">Live</option>
                </select>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Client ID</label>
                <input type="text" class="form-control" name="client_id" placeholder="" required>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Secret ID</label>
                <input type="text" class="form-control" name="secret_id" placeholder="" required>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Merchant ID</label>
                <input type="text" class="form-control" name="merchant_id" placeholder="" required>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <x-admin.modal.create-btn />

</form>