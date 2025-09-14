<form class="form-load" action="{{ route('admin.seoSettings.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">

            <h3 class="card-title">Global SEO & Tracking Settings</h3>

            <div class="row">
                <div class="col-lg-12 mt-3">
                    <label>Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" value="{{ @$meta_title }}" maxlength="60">
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Meta Description</label>
                    <textarea class="form-control" name="meta_description" rows="2" maxlength="160">{{ @$meta_description }}</textarea>
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Meta Keywords</label>
                    <input type="text" class="form-control" name="meta_keywords" value="{{ @$meta_keywords }}">
                </div>

                <div class="col-lg-12 mt-3">
                    <label>OG Image [1200 × 630 px]</label>
                    <img id="ogimg" src="{{ @$meta_og_image ? asset($meta_og_image) : '' }}" width="50%">
                    <input type="file" class="form-control" name="meta_og_image" oninput="ogimg.src=window.URL.createObjectURL(this.files[0])">
                </div>

                <div class="col-lg-12 mt-3">
                    <label>OG Image Alt</label>
                    <input type="text" class="form-control" name="meta_og_alt" value="{{ @$meta_og_alt }}">
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Google Analytics / GA4</label>
                    <textarea class="form-control" name="google_analytics">{{ @$google_analytics }}</textarea>
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Google Tag Manager</label>
                    <textarea class="form-control" name="google_tag_manager">{{ @$google_tag_manager }}</textarea>
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Facebook / Meta Pixel</label>
                    <textarea class="form-control" name="facebook_pixel">{{ @$facebook_pixel }}</textarea>
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Google Site Verification</label>
                    <input type="text" class="form-control" name="google_site_verification" value="{{ @$google_site_verification }}">
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Bing Site Verification</label>
                    <input type="text" class="form-control" name="bing_site_verification" value="{{ @$bing_site_verification }}">
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Yandex Site Verification</label>
                    <input type="text" class="form-control" name="yandex_site_verification" value="{{ @$yandex_site_verification }}">
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Default Twitter Card</label>
                    <input type="text" class="form-control" name="default_twitter_card" value="{{ @$default_twitter_card }}">
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Default Schema Type</label>
                    <input type="text" class="form-control" name="default_schema_type" value="{{ @$default_schema_type }}">
                </div>
            </div>

            <button class="btn btn-primary mt-3">Update</button>
        </div>
    </div>
</form>
