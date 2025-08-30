<form class="form-load" type="update" action="{{ route('admin.units.update', $unit->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Unit Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{$unit->unit_name}}" name="unit_name" placeholder="Unit Name" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Short Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="short_name" placeholder="Short Name" required value="{{$unit->short_name}}">
            </div>
        </div>
    </div>

    <x-admin.modal.update-btn />
    
</form>