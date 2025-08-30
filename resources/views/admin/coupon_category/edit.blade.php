<form class="form-load" type="update" action="{{ route('admin.coupon_categorys.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Category Name</label>
                <input type="text" class="form-control" value="{{$category->category_name}}" name="category_name" placeholder="Category Name" required>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 600 * 600 px]</label>
                <img id="categoryimg" src="{{asset('frontend/images/coupon/'.$category->image)}}" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        
    </div>

    <x-admin.modal.update-btn />
    
</form>