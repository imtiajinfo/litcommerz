<form class="form-load" type="update" action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Blog Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="blog_name" value="{{$blog->title}}" placeholder="Blog Name" required>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 600 * 600 px]<span class="text-danger">*</span></label>
                <img id="categoryimg" src="{{asset('frontend/images/blog/'.$blog->image)}}" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <label class="required">Short Description</label>
            <textarea placeholder="Short Description" class="form-control" rows="5" name="short_description">{{$blog->short_description}}</textarea>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <label class="required">Long Description</label>
            <textarea id="long_desc" placeholder="Long Description" name="long_description">{{$blog->long_description}}</textarea>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" id="">
                    <option @if($blog->status == 1){{"selected"}}@endif value="1">Active</option>
                    <option @if($blog->status == 2){{"selected"}}@endif value="2">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <x-admin.modal.update-btn />
    
</form>
<script>
    $('#long_desc').summernote({height:200,minHeight:null,maxHeight:null,focus:true});
</script>