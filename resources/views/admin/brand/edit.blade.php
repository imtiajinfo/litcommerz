<form class="form-load" type="update" action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Brand Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{$brand->brand_name}}" name="brand_name" placeholder="brand Name" required>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 200 * 60 px]<span class="text-danger">*</span></label>
                <img id="brandimg" src="{{asset('frontend/images/brand/'.$brand->image)}}" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="brandimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" id="">
                    <option @if($brand->status == 1){{"selected"}}@endif value="1">Active</option>
                    <option @if($brand->status == 2){{"selected"}}@endif value="2">Inactive</option>
                </select>
            </div>
        </div>

    </div>

    <x-admin.modal.update-btn />
    
</form>