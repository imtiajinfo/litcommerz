<form class="form-load" type="create" action="{{ route('admin.subcategory.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">

        {{-- Select Category --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required">Select Category<span class="text-danger">*</span></label>
                <select class="form-control" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Sub Category Name --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required">Sub Category Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="subcategory_name" placeholder="Sub Category Name" required>
            </div>
        </div>

        {{-- Image --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Image [600x600 px]</label>
                <img id="categoryimg" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>

        {{-- Image Alt --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Image Alt Text</label>
                <input type="text" class="form-control" name="image_alt" placeholder="Describe the category image for SEO">
            </div>
        </div>

        {{-- Status --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
        </div>

        {{-- Slug --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Slug</label>
                <input type="text" class="form-control" name="slug" placeholder="Custom URL slug (leave empty to auto-generate)">
            </div>
        </div>


        {{-- Sorting No --}}
        <div class="col-lg-12 d-none">
            <div class="form-group">
                <label>Sorting No.</label>
                <input type="number" class="form-control" name="sl" value="0" min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>

        {{-- SEO Fields --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" class="form-control" name="meta_title" placeholder="Meta Title">
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Description</label>
                <textarea class="form-control" name="meta_description" rows="2" placeholder="Meta Description"></textarea>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Keywords</label>
                <input type="text" class="form-control" name="meta_keywords" placeholder="keyword1, keyword2">
            </div>
        </div>

        {{-- OG Image --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>OG Image [1200x630 px]</label>
                <img id="ogimg" width="50%">
                <input type="file" name="meta_og_image" class="form-control" oninput="ogimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>

        {{-- OG Image Alt --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>OG Image Alt Text</label>
                <input type="text" class="form-control" name="meta_og_alt" placeholder="OG Image Alt">
            </div>
        </div>

    </div>

    <x-admin.modal.create-btn />
</form>