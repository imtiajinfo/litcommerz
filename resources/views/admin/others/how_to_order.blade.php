<div class="page-header">
    <div class="page-title">
        <h4>How To Order Section</h4>
        <h6>Update How To Order</h6>
    </div>
</div>

<form class="form-load" type="create" action="{{ route('admin.howToOrder.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card">
        <div class="card-body">
            {{-- How To Order Content --}}
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12">
                    <textarea id="summernote" name="value">{{ @$value }}</textarea>
                </div>
            </div>

            {{-- SEO & Open Graph Section --}}
            <h3 class="card-title my-3">SEO & Open Graph Settings</h3>

            <div class="row">
                {{-- Meta Title --}}
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ @$meta_title }}" maxlength="60" placeholder="Best SEO title (max 60 chars)">
                    </div>
                </div>

                {{-- Meta Description --}}
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="2" maxlength="160" placeholder="Short description for search engines (max 160 chars)">{{ @$meta_description }}</textarea>
                    </div>
                </div>

                {{-- Meta Keywords --}}
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Meta Keywords</label>
                        <input type="text" class="form-control" name="meta_keywords" value="{{ @$meta_keywords }}" placeholder="keyword1, keyword2, keyword3">
                    </div>
                </div>

                {{-- OG Image --}}
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Open Graph (OG) Image [Size: 1200 × 630 px]</label>
                        <img id="ogimg" src="{{ @$meta_og_image ? asset($meta_og_image) : '' }}" width="50%" height="auto">
                        <input type="file" name="meta_og_image" class="form-control" oninput="ogimg.src=window.URL.createObjectURL(this.files[0])">
                    </div>
                </div>

                {{-- OG Image Alt --}}
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>OG Image Alt Text</label>
                        <input type="text" class="form-control" name="meta_og_alt" value="{{ @$meta_og_alt }}" placeholder="Describe the OG image for SEO">
                    </div>
                </div>
            </div>

            <button class="btn btn-primary mt-3">Update</button>
        </div>
    </div>
</form>

<script>
    $('#summernote').summernote({
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: true
    });
</script>