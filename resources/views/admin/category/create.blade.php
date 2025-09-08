<form class="form-load" type="create" action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">

        {{-- Category Name --}}
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Category Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="category_name" placeholder="Category Name" required>
            </div>
        </div>

        {{-- Category Image --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 600 * 600 px]<span class="text-danger">*</span></label>
                <img id="categoryimg" width="50%" height="auto">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>

        {{-- Category Image Alt Text --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Image Alt Text</label>
                <input type="text" class="form-control" name="image_alt" placeholder="Describe the category image for SEO">
            </div>
        </div>

        {{-- Status --}}
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
        </div>

        {{-- Home Show --}}
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Home Show</label>
                <select class="form-control" name="home_show">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>

        {{-- ===================== SEO Fields ===================== --}}

        {{-- Slug --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Slug</label>
                <input type="text" class="form-control" name="slug" placeholder="Custom URL slug (leave empty to auto-generate)">
            </div>
        </div>

        {{-- Meta Title --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" class="form-control" name="meta_title" maxlength="60" placeholder="Best SEO title (max 60 chars)">
            </div>
        </div>

        {{-- Meta Description --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Description</label>
                <textarea class="form-control" name="meta_description" rows="2" maxlength="160" placeholder="Short description for search engines (max 160 chars)"></textarea>
            </div>
        </div>

        {{-- Meta Keywords --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Keywords</label>
                <input type="text" class="form-control" name="meta_keywords" placeholder="keyword1, keyword2, keyword3">
            </div>
        </div>

        {{-- OG Image --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Open Graph (OG) Image [Size: 1200 × 630 px]</label>
                <img id="ogImgPreview" width="50%" height="auto">
                <input type="file" name="meta_og_image" class="form-control" accept="image/*"
                    oninput="ogImgPreview.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>

        {{-- OG Image Alt --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>OG Image Alt Text</label>
                <input type="text" class="form-control" name="meta_og_alt" placeholder="Describe the OG image for SEO">
            </div>
        </div>

    </div>

    <x-admin.modal.create-btn />
</form>