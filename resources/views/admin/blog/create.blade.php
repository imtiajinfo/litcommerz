<form class="form-load" type="create" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Blog Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="blog_name" placeholder="Blog Name" required>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 600 * 600 px]<span class="text-danger">*</span></label>
                <img id="categoryimg" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <label class="required">Short Description</label>
            <textarea placeholder="Short Description" class="form-control" rows="5" name="short_description"></textarea>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <label class="required">Long Description</label>
            <textarea id="long_desc" placeholder="Long Description" name="long_description"></textarea>
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

<script>
    $('#long_desc').summernote({height:200,minHeight:null,maxHeight:null,focus:true});
</script>


