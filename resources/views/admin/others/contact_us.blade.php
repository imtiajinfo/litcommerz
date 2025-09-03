<div class="page-header">
    <div class="page-title">
        <h4>Contact Section</h4>
        <h6>Update Contact Section</h6>
    </div>
    <div class="page-btn">
        
    </div>
</div>

@csrf

<div class="card">
    <div class="card-body">
        <form class="form-load" type="create" action="{{ route('admin.contactUs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12">
                    <textarea id="summernote" name="value">{{@$value}}</textarea>
                </div>
            </div>
            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<script>

    $('#summernote').summernote({height:200,minHeight:null,maxHeight:null,focus:true});
</script>



