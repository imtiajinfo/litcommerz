<form class="form-load" type="update" action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Category Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{$category->category_name}}" name="category_name" placeholder="Category Name" required>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 600 * 600 px]<span class="text-danger">*</span></label>
                <img id="categoryimg" src="{{asset('frontend/images/category/'.$category->image)}}" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" id="">
                    <option @if($category->status == 1){{"selected"}}@endif value="1">Active</option>
                    <option @if($category->status == 2){{"selected"}}@endif value="2">Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Home Show</label>
                <select class="form-control" name="home_show" id="">
                    <option @if($category->home_show == 1){{"selected"}}@endif value="1">Yes</option>
                    <option @if($category->home_show == 0){{"selected"}}@endif value="0">No</option>
                </select>
            </div>
        </div>
    </div>

    <x-admin.modal.update-btn />
    
</form>