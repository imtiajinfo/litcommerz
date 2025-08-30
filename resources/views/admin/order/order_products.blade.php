<div class="row">
    <div class="col-12 d-flex">
        <div class="card flex-fill bg-white">
            <div class="card-body">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <table class="table datanew dataTable no-footer" id="DataTables_Table_0" role="grid"
                            aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting">Sl</th>
                                    <th class="sorting">Product Name</th>
                                    <th class="sorting">Image</th>
                                    <th class="sorting">Amount</th>
                                    <th class="sorting">Per Discount</th>
                                    <th class="sorting">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
        
                                @foreach ($products as $key => $item)
                                    <tr class="odd">
                                        <td class="sorting_1">
                                            {{-- {{ ($products->currentPage() - 1) * $products->perPage() + $key + 1 }} --}}
                                            {{ $key + 1 }}
                                        </td>
                                        <td><a target="_blank" href="{{ url('product/'.$item->slug) }}">{{Str::limit($item->product_name, 30)}} @if(@$item->short_name)({{$item->weight??'1'}}{{@$item->short_name}})@endif</a></td>
                                        <td>
                                            <a target="_blanck" href="{{ url('product/'.$item->slug) }}"><img src="{{asset('frontend/images/product/'.Helper::product_first_img($item->product_id)->image)}}" style="height:80px"></a>
                                        </td>
                                        <td>{{$item->product_price}}</td>
                                        <td>{{$item->discount}}</td>
                                        <td>{{$item->quantity}}</td>
                                    </tr>
                                @endforeach
        
                            </tbody>
                        </table>
                                                
                    </div>
                </div>
        
            </div>
        </div>
    </div>
</div>