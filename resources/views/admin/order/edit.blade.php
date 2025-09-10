<div class="row">
    <div class="col-12 d-flex">
        <div class="card flex-fill bg-white">
            <div class="card-body">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

                        

                        <form class="form-load" type="create" action="{{ route('admin.order_update', $id) }}" method="post">
                            @csrf
                        
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="required">Select Category</label>
                                    <select id="category-id-order-edit" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $item)
                                            <option value="{{$item->id}}">{{$item->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="sub_category_order_edit" class="col-md-3">
                                    <label class="required">Select Sub Category</label>
                                    <select class="form-control" name="subcategory_id">
                                        <option value="">Select Sub Category</option>
                                        @foreach ($subcategories as $item)
                                            <option value="{{$item->id}}">{{$item->subcategory_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3" id="product-view-order">
                                    <label class="required">Select Product</label>
                                    <select name="" id="addNewProduct" class="form-select">
                                        <option value="">Select Product</option>
                                        @foreach ($all_products as $item1)
                                        <option value="{{ json_encode($item1) }}">{{ $item1->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <button type="button" id="addNewProductButton" class="btn btn-primary mt-1">Add Product</button>
                                </div>
                                <div class="col-9 mt-3">
                                    <div class="form-group">
                                      <label class="required">Search Product...</label>
                                        <select class="form-select tom-select" id="selectproduct2">
                                            <option value="">Select</option>
                                            @foreach ($productList as $item)
                                                <option value="{{ json_encode($item) }}">{{$item->product_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-5">
                                    <button type="button" id="addNewProductButton2" class="btn btn-primary mt-1">Add Product</button>
                                </div>
                            </div>
                            <table class="table datanew dataTable no-footer" id="DataTables_Table_0" role="grid"
                                aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting">Product Name</th>
                                        <th class="sorting">Image</th>
                                        <th class="sorting">Amount</th>
                                        <th class="sorting">Per Discount</th>
                                        <th class="sorting">Quantity</th>
                                        <th class="sorting">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="productAddSection">
            
                                    @foreach ($products as $key => $item)
                                        <tr class="odd">
                                            
                                            <td>
                                                <input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
                                                <a target="_blank" href="{{ url('product/'.$item->slug) }}">{{Str::limit($item->product_name, 30)}} @if(@$item->short_name)({{$item->weight??'1'}}{{@$item->short_name}})@endif</a>
                                            </td>
                                            <td>
                                                <a target="_blanck" href="{{ url('product/'.$item->slug) }}"><img src="{{asset('frontend/images/product/'.Helper::product_first_img($item->product_id)->image)}}" style="height:80px"></a>
                                            </td>
                                            <td>
                                                <input min="1" type="number" step="any" class="form-control" value="{{$item->product_price}}" name="product_price[]">
                                            </td>
                                            <td>
                                                <input  min="0" type="number" step="any" class="form-control" value="{{$item->discount}}" name="discount[]">
                                            </td>
                                            <td>
                                                <input min="1" type="number" step="any" class="form-control" value="{{$item->quantity}}" name="quantity[]">
                                            </td>
                                            <td>
                                                <button class="btn btn-danger productRemove">Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach
            
                                </tbody>
                            </table>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label class="required">Shipping Amount ({{ $setting->currency_icon }})</label>
                                    <input type="number" step="any" name="shipping_amount" class="form-control" value="{{ $order->shipping_amount ?? 0 }}">
                                </div>

                                <div class="col-md-9">
                                    <label>Order Note</label>
                                    <textarea name="note" class="form-control" rows="2">{{ $order->notes ?? '' }}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success m-2">Update</button>
                            
                        </form>  

                        <div class="row">
                            @if(!empty($oldOrderRecord))

                            <h3 class="text-bold mt-4">Old Order Record</h3>
                                <table class="mb-3 table datanew dataTable no-footer" id="DataTables_Table_0" role="grid"
                                aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting">Product Name</th>
                                        <th class="sorting">Image</th>
                                        <th class="sorting">Amount</th>
                                        <th class="sorting">Per Discount</th>
                                        <th class="sorting">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
            
                                    @foreach (json_decode($oldOrderRecord->value) as $key => $item)
                                        <tr class="odd">
                                            @php
                                                $helperProduct = Helper::singleProductInfo($item->product_id);
                                            @endphp
                                            
                                            <td>
                                                <a target="_blank" href="{{ url('product/'.@$helperProduct->slug) }}">{{Str::limit(@$helperProduct->product_name, 30)}} @if(@$helperProduct->short_name)({{@$helperProduct->weight??'1'}}{{@$helperProduct->short_name}})@endif</a>
                                            </td>
                                            <td>
                                                <a target="_blanck" href="{{ url('product/'.@$helperProduct->slug) }}"><img src="{{asset('frontend/images/product/'.Helper::product_first_img($item->product_id)->image)}}" style="height:80px"></a>
                                            </td>
                                            <td>
                                                <input disabled type="number" step="any" class="form-control" value="{{$item->product_price}}" name="product_price[]">
                                            </td>
                                            <td>
                                                <input disabled type="number" step="any" class="form-control" value="{{$item->discount}}" name="discount[]">
                                            </td>
                                            <td>
                                                <input disabled type="number" step="any" class="form-control" value="{{$item->quantity}}" name="quantity[]">
                                            </td>
                                        </tr>
                                    @endforeach
            
                                </tbody>
                            </table>
                            @endif
                        </div>

                    </div>
                </div>
        
            </div>
        </div>
    </div>
</div>

<script>
  new TomSelect('.tom-select', {
    maxItems: 1,
    hideSearch: false,
  });
</script>

<script>
$(document).ready(function(){
    $(document).on('change', '#category-id-order-edit', function(e){
        e.preventDefault();
        let category_id = $(this).val();
        $.ajax({
            type: 'get',
            url: "{{url('category-wise-sub-category')}}/"+category_id,
            dataType: 'html',
            success: function (data) {
                $("#sub_category_order_edit").html(data);
            }
        });
        $.ajax({
            type: 'get',
            url: "{{url('load-product')}}",
            data: {category_id: category_id},
            dataType: 'html',
            success: function (data) {
                $("#product-view-order").html(data);
            }
        });
    });

    $(document).on('change', "[name='subcategory_id']", function (e) {
        e.preventDefault();
        let sub_category_id = $(this).val();
        $.ajax({
            type: 'get',
            url: "{{url('load-product')}}",
            data: {sub_category_id: sub_category_id},
            dataType: 'html',
            success: function (data) {
                $("#product-view-order").html(data);
            }
        });
    });
});
</script>