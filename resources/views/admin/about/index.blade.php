<div class="page-header">
    <div class="page-title">
        <h4>About Section</h4>
        <h6>Update About</h6>
    </div>
    <div class="page-btn">
        
    </div>
</div>

@csrf

<div class="card">
    <div class="card-body">
        <form class="form-load" type="create" action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12">
                    <textarea id="about" name="about">{{@$setting->about}}</textarea>
                </div>
            </div>
            <button class="btn btn-primary">Update</button>
        
            
        </form>
    </div>
</div>

<script>

    $('#about').summernote();
</script>



