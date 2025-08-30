<div class="page-header">
    <div class="page-title">
        <h4>Product list</h4>
        <h6>View/Search product</h6>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Product" modalSize="lg" url="product/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Product
        </a>
    </div>
</div>

@csrf

<div class="card">
    <div class="card-body">
        <div class="table-top">

            @include('components.admin.search')

            <div class="wordset" style="margin-right:auto;">
                <ul style="padding-left:0;margin:0;list-style:none;display:flex;align-items:center;gap:10px;">
                    <li>
                        <div class="form-group" style="float: left;margin-right:5px">
                            <label class="required">Select Category</label>
                            <select onchange="change(this.value, 'category_id')" class="form-control custom-select custom-select-sm" name="category_id" required id="category-id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $item)
                                    <option @selected($item->id == $category_id) value="{{$item->id}}">{{$item->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="sub_category" style="float: left">
                            <label class="required">Select Sub Category</label>
                            <select onchange="change(this.value, 'sub_category_id')" class="form-control custom-select custom-select-sm" name="subcategory_id">
                                <option value="">Select Sub Category</option>
                                @foreach ($subcategories as $item)
                                    <option @selected($item->id == $sub_category_id) value="{{$item->id}}">{{$item->subcategory_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="product-view" style="float: left; margin-left:5px; display:none;">
                        </div>

                    </li>
                    <li>
                        @include('components.admin.perpage')
                    </li>
                    <li>
                        <a href="product" class="btn btn-primary anchor">
                          <i class="fas fa-sync-alt"></i>
                      </a>
                    </li>
                    <li>
                        {{-- <x-admin.print-button /> --}}
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <table class="table datanew dataTable no-footer" id="DataTables_Table_0" role="grid"
                    aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting">Sl</th>
                            <th class="sorting">ProductName</th>
                            <th class="sorting">BuyPrice</th>
                            <th class="sorting">SellPrice</th>
                            <th class="sorting">Stock</th>
                            {{-- <th class="sorting">Old Category</th>
                            <th class="sorting">Old SubCategory</th> --}}
                            <th class="sorting">Category</th>
                            <th class="sorting">SubCategory</th>
                            <th class="sorting">Display No.</th>
                            <th class="sorting">Unit</th>
                            {{-- <th class="sorting">Offer Category</th> --}}
                            <th class="sorting">Offer</th>
                            {{-- <th class="sorting">Sl</th> --}}
                            <th>Image</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $paginate = $products;
                        @endphp

                        @foreach ($products as $key => $item)
                            <tr class="odd">
                                <td class="sorting_1">
                                    {{ ($products->currentPage() - 1) * $products->perPage() + $key + 1 }}
                                </td>
                                <td>{{ Str::limit($item->product_name, 50) }}</td>
                                <td>{{ $item->buy_price }}</td>
                                <td>{{ $item->sell_price }}</td>
                                <td>{{ $item->available_stock }}</td>
                                {{-- <td>{{ $item->category->category_name }}</td>
                                <td>{{ $item->subcategory->subcategory_name ?? '' }}</td> --}}
                                <td style="text-align: left; width: 10%;">
                                    {!! $item->categories->map(function($cat, $index) {
                                        return ($index + 1) . '. ' . $cat->category_name;
                                    })->implode('<br>') !!}
                                </td>
                                <td style="text-align: left; width: 10%;">
                                    {!! $item->categories->map(function($cat, $index) use ($all_subcategories) {
                                        $sub = $all_subcategories[$cat->pivot->subcategory_id]->subcategory_name ?? '';
                                        return ($index + 1) . '. ' . $sub;
                                    })->implode('<br>') !!}
                                </td>
                                <td style="text-align: left; width: 5%;">
                                    {!! $item->categories->map(function($cat, $index) {
                                        return ($index + 1) . '. ' . $cat->pivot->sl;
                                    })->implode('<br>') !!}
                                </td>

                                <td>{{ $item->weight }} {{ $item->unit_name }}</td>
                                {{-- <td>{{ $item->offer_category }}</td> --}}
                                <td>{{ $item->offer_amount }}</td>
                                {{-- <td>{{ $item->sl }}</td> --}}
                                <td>
                                    <img class="img-fluid" src="{{ asset('frontend/images/product/' . ($item->first_img->image ?? 'no-image.png')) }}" alt="{{ $item->product_name }}">
                                </td>
                                
                                <td class="action text-center">

                                    <button class="btn btn-sm btn-primary show-modal mb-1" type="show" modalTitle="{{ Str::limit($item->product_name,40) }}" modalSize="md" url="product/{{$item->id}}">Images</button><br>
                                    <button class="btn btn-sm btn-info show-modal mb-1"
                                        type="show"
                                        modalTitle="Reviews - {{ Str::limit($item->product_name, 40) }}"
                                        modalSize="lg"
                                        url="product/{{ $item->id }}/reviews">
                                        Reviews
                                    </button><br>

                                    <button class="btn btn-sm btn-secondary d-none mb-1">@if($item->status == 1){{"Active"}}@else{{"Invactive"}}@endif</button><br>

                                    <a class="me-3 data-edit mt-1" data-id="{{ $item->id }}" url="product/{{ $item->id }}/edit" hideModal="hide" modalTitle="Edit Product" modalSize="lg">
                                        <img src="{{ asset('admin/assets/img/icons/edit.svg') }}" alt="img">
                                    </a>
                                    <a data-id="{{ $item->id }}" url="/product/{{$item->id}}" class="me-3 mt-1 confirm-text delete" href="javascript:void(0);">
                                        <img src="{{ asset('admin/assets/img/icons/delete.svg') }}" alt="img">
                                    </a>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                
                @include('components.admin.pagination')
                
            </div>
        </div>

    </div>
</div>

<style>
    table{
        width: 100%
    }
</style>

{{-- 
<script>
  $(document).on('change', "[name='subcategory_id']", function (e) {
    e.preventDefault();
    let sub_category_id = $(this).val();

    $.ajax({
        type: 'get',
        url: "{{ url('load-product') }}",
        data: { sub_category_id: sub_category_id },
        dataType: 'html',
        success: function (data) {
            $("#product-view").html(data).show();
        }
    });
});

</script> --}}