<div class="page-header">
    <div class="page-title">
        <h4>Stock Ledger list</h4>
        <h6>View/Search Stock Ledger</h6>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Stock" modalSize="md" url="stocks/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Stock
        </a>
    </div>
</div>

@csrf

<div class="card">
    <div class="card-body">
        <div class="table-top">

            @include('components.admin.search')

            <div class="wordset">
                <ul>
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
                            <th class="sorting">Product name</th>
                            <th class="sorting">Image</th>
                            <th class="sorting">Status</th>
                            {{-- <th class="sorting">Buy/Sell Price</th> --}}
                            <th class="text-center">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $paginate = $stock_ledgers;
                        @endphp

                        @foreach ($stock_ledgers as $key => $item)
                            <tr class="odd">
                                <td class="sorting_1">
                                    {{ ($stock_ledgers->currentPage() - 1) * $stock_ledgers->perPage() + $key + 1 }}
                                </td>
                                <td class="productimgname">
                                    <a href="javascript:void(0);">{{ $item->product_name }}</a>
                                </td>
                                <td class=" text-center" data-id="{{ $item->id }}">
                                    <img src="{{asset('frontend/images/product/'.Helper::product_first_img($item->product_id)->image)}}" style="height:80px">
                                </td>
                                <td>
                                    @if($item->type == 1)
                                    {{"Stock In"}}
                                    @else
                                    {{"Stock Out"}}
                                    @endif
                                </td>
                                {{-- <td>{{ $item->amount }}</td> --}}
                                <td>{{$item->qty}}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @include('components.admin.pagination')
                
            </div>
        </div>

    </div>
</div>

