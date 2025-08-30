<form class="form-load" type="update" action="{{ route('admin.subcategory.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Select Category<span class="text-danger">*</span></label>
                <select class="form-control" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $item)
                        <option @if($subcategory->category_id == $item->id){{"selected"}}@endif value="{{$item->id}}">{{$item->category_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Category Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{$subcategory->subcategory_name}}" name="subcategory_name" placeholder="Category Name" required>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 600 * 600 px]</label>
                <img id="categoryimg" src="{{asset('frontend/images/subcategory/'.$subcategory->image)}}" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" id="">
                    <option @if($subcategory->status == 1){{"selected"}}@endif value="1">Active</option>
                    <option @if($subcategory->status == 2){{"selected"}}@endif value="2">Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Sorting No.</label>
                <input type="number" class="form-control" name="sl" placeholder="Sorting No." value="{{ $subcategory->sl }}" min="1" required min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>
    </div>

    <x-admin.modal.update-btn />
    
</form>