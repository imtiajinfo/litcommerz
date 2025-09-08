<form class="form-load" type="update" action="{{ route('admin.subcategory.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">

        {{-- Select Category --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required">Select Category<span class="text-danger">*</span></label>
                <select class="form-control" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" @if($subcategory->category_id == $item->id) selected @endif>{{ $item->category_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Sub Category Name --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required">Sub Category Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{ $subcategory->subcategory_name }}" name="subcategory_name" placeholder="Sub Category Name" required>
            </div>
        </div>

        {{-- Image --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Image [600x600 px]</label>
                <img id="categoryimg" src="{{ asset('frontend/images/subcategory/'.$subcategory->image) }}" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>

        {{-- Image Alt --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Image Alt Text</label>
                <input type="text" class="form-control" name="image_alt" value="{{ $subcategory->image_alt }}">
            </div>
        </div>

        {{-- Status --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status">
                    <option value="1" @if($subcategory->status==1) selected @endif>Active</option>
                    <option value="2" @if($subcategory->status==2) selected @endif>Inactive</option>
                </select>
            </div>
        </div>

        {{-- Sorting No --}}
        <div class="col-lg-12 d-none">
            <div class="form-group">
                <label>Sorting No.</label>
                <input type="number" class="form-control" name="sl" value="{{ $subcategory->sl }}" min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>

        {{-- SEO Fields --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" class="form-control" name="meta_title" value="{{ $subcategory->meta_title }}">
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Description</label>
                <textarea class="form-control" name="meta_description" rows="2">{{ $subcategory->meta_description }}</textarea>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label>Meta Keywords</label>
                <input type="text" class="form-control" name="meta_keywords" value="{{ $subcategory->meta_keywords }}">
            </div>
        </div>

        {{-- OG Image --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>OG Image [1200x630 px]</label>
                <img id="ogimg" src="{{ asset('frontend/images/subcategory/og/'.$subcategory->meta_og_image) }}" width="50%">
                <input type="file" name="meta_og_image" class="form-control" oninput="ogimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>

        {{-- OG Image Alt --}}
        <div class="col-lg-12">
            <div class="form-group">
                <label>OG Image Alt Text</label>
                <input type="text" class="form-control" name="meta_og_alt" value="{{ $subcategory->meta_og_alt }}">
            </div>
        </div>

    </div>

    <x-admin.modal.update-btn />
</form>
