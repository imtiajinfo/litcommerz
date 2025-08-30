<form class="form-load" type="create" action="{{ route('admin.offer_products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <input type="hidden" name="offer_id" value="{{$offer_id}}">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Product</label>
                <select class="form-control tom-select" name="product_id" id="">
                    <option value="">Select</option>
                    @foreach ($products as $item)
                        <option value="{{$item->id}}">{{$item->product_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Type</label>
                <select class="form-control" name="is_percentage" id="">
                    <option value="">Select</option>
                    <option value="1">Percentage</option>
                    <option value="2">Amount</option>
                </select>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Amount/Percentage</label>
                <input type="number" class="form-control" name="value" placeholder="Amount/Percentage" required min="1" oninput="this.value = this.value < 1 ? 1 : this.value">
            </div>
        </div>
        
    </div>

    <x-admin.modal.create-btn />
    
</form>

<script>
  new TomSelect('.tom-select', {
    maxItems: 1,
    hideSearch: false,
  });
</script>