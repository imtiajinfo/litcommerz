<form class="form-load" type="create" action="{{ route('admin.newArrivals.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Select Product</label>
                <select class="form-control" name="product_id" required>
                    <option value="">Select Product</option>
                    @foreach ($products as $item)
                        <option value="{{$item->id}}">{{$item->product_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
    </div>

    <x-admin.modal.create-btn />
    
</form>



