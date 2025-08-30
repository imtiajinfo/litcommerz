<form class="form-load" type="update" action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Type<span class="text-danger">*</span></label>
                <select @if($banner->type == 2) readonly @endif class="form-control" name="type" id="">
                    @if($banner->type == 1)
                        <option @if($banner->type == 1){{"selected"}}@endif value="1">Home</option>
                    @endif
                    @if($banner->type == 2)
                        <option @if($banner->type == 2){{"selected"}}@endif value="2">Home Middle</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image<span class="text-danger">*</span> @if($banner->type == 1)[Size: 1500 * 234 px] @elseif($banner->type==2)[Size: 1000 * 510 px]@endif</label>
                <img id="bannerimg" src="{{asset('frontend/images/banner/'.$banner->image)}}" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="bannerimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" id="">
                    <option @if($banner->status == 1){{"selected"}}@endif value="1">Active</option>
                    <option @if($banner->status == 2){{"selected"}}@endif value="2">Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Link<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{$banner->link}}" name="link" placeholder="Link" required>
            </div>
        </div>
        
    </div>

    <x-admin.modal.update-btn />
    
</form>