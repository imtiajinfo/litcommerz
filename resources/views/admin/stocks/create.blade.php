<form class="form-load" type="create" action="{{ route('admin.stocks.store') }}" method="POST" enctype="multipart/form-data">
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
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Quantity</label>
                <input type="text" class="form-control" name="qty" placeholder="Quantity" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Buy Price</label>
                <input type="text" class="form-control" name="buy_price" placeholder="Buy Price" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Sell Price</label>
                <input type="text" class="form-control" name="sell_price" placeholder="Sell Price" required>
            </div>
        </div>
        
    </div>

    <x-admin.modal.create-btn />
    
</form>

<script>
    $(document).ready(function(){
        $("#product-id").change(function(e){
            e.preventDefault();
            let product_id = $(this).val();
            $.ajax({
                type: 'get',
                url: "{{url('product-wise-sub-product')}}/"+product_id,
                dataType: 'html',
                success: function (data) {
                    $("#sub_category").html(data);
                }
            });
        })
    })

</script>


