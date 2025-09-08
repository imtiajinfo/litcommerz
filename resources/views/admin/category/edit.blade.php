<form class="form-load" type="update" action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">

        {{-- Category Name --}}
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Category Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{ $category->category_name }}" name="category_name" placeholder="Category Name" required>
            </div>
        </div>

        {{-- Category Image --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 600 * 600 px]<span class="text-danger">*</span></label>
                <img id="categoryimg" src="{{asset('frontend/images/category/'.$category->image)}}" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>

        {{-- Category Image Alt --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Image Alt Text</label>
                <input type="text" class="form-control" name="image_alt" value="{{ $category->image_alt }}" placeholder="Describe the category image for SEO">
            </div>
        </div>

        {{-- Status --}}
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status">
                    <option value="1" @if($category->status == 1) selected @endif>Active</option>
                    <option value="2" @if($category->status == 2) selected @endif>Inactive</option>
                </select>
            </div>
        </div>

        {{-- Home Show --}}
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Home Show</label>
                <select class="form-control" name="home_show">
                    <option value="1" @if($category->home_show == 1) selected @endif>Yes</option>
                    <option value="0" @if($category->home_show == 0) selected @endif>No</option>
                </select>
            </div>
        </div>

        {{-- ===================== SEO Fields ===================== --}}

        {{-- Slug --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Slug</label>
                <input type="text" class="form-control" name="slug" value="{{ $category->slug }}" placeholder="Custom URL slug (leave empty to auto-generate)">
            </div>
        </div>

        {{-- Meta Title --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" class="form-control" name="meta_title" value="{{ $category->meta_title }}" maxlength="60" placeholder="Best SEO title (max 60 chars)">
            </div>
        </div>

        {{-- Meta Description --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Description</label>
                <textarea class="form-control" name="meta_description" rows="2" maxlength="160" placeholder="Short description for search engines (max 160 chars)">{{ $category->meta_description }}</textarea>
            </div>
        </div>

        {{-- Meta Keywords --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Keywords</label>
                <input type="text" class="form-control" name="meta_keywords" value="{{ $category->meta_keywords }}" placeholder="keyword1, keyword2, keyword3">
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label>Open Graph (OG) Image [Size: 1200 × 630 px]</label>
                <img id="ogimg" src="{{ asset('frontend/images/category/og/'.$category->meta_og_image) }}" width="50%" height="auto">
                <input type="file" name="meta_og_image" class="form-control" oninput="ogimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>



        {{-- OG Image Alt --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>OG Image Alt Text</label>
                <input type="text" class="form-control" name="meta_og_alt" value="{{ $category->meta_og_alt }}" placeholder="Describe the OG image for SEO">
            </div>
        </div>

    </div>

    <x-admin.modal.update-btn />
</form>