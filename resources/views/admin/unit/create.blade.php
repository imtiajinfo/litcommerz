<form class="form-load" type="create" action="{{ route('admin.units.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Unit Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="unit_name" placeholder="Unit Name" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Short Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="short_name" placeholder="Short Name" required>
            </div>
        </div>
    </div>

    <x-admin.modal.create-btn />
    
</form>


