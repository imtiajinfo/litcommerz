<div class="page-header">
    <div class="page-title">
        <h4>About Us Section</h4>
        <h6>Update About Us</h6>
    </div>
</div>

<form class="form-load" type="create" action="{{ route('admin.aboutUs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card">
        <div class="card-body">
            {{-- About Us Content --}}
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12">
                    <textarea id="summernote" name="value">{{ @$value }}</textarea>
                </div>
            </div>

            <h3 class="card-title my-3">SEO & Open Graph Settings</h3>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ @$meta_title }}" maxlength="60">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="2" maxlength="160">{{ @$meta_description }}</textarea>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Meta Keywords</label>
                        <input type="text" class="form-control" name="meta_keywords" value="{{ @$meta_keywords }}">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Open Graph (OG) Image [1200 × 630 px]</label>
                        <img id="ogimg" src="{{ @$meta_og_image ? asset($meta_og_image) : '' }}" width="50%">
                        <input type="file" name="meta_og_image" class="form-control" oninput="ogimg.src=window.URL.createObjectURL(this.files[0])">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label>OG Image Alt Text</label>
                        <input type="text" class="form-control" name="meta_og_alt" value="{{ @$meta_og_alt }}">
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
        focus: true
    });
</script>