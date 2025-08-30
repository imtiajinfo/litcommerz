<form class="form-load" type="create" action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Type<span class="text-danger">*</span></label>
                <select class="form-control" name="type" id="">
                    <option value="1">Home Banner</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 1500 * 234 px]<span class="text-danger">*</span></label>
                <img id="bannerimg" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="bannerimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Link<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="link" placeholder="Link" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" id="">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <x-admin.modal.create-btn />
    
</form>


