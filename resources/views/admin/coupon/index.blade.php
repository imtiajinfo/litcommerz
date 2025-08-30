<div class="page-header">
    <div class="page-title">
        <h4>Coupon list</h4>
        <h6>View/Search Coupon</h6>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Coupon" modalSize="lg" url="coupons/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Coupon
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
                        @include('components.admin.perpage')
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
                            <th class="sorting">Coupon Name</th>
                            {{-- <th class="sorting">Category Name</th> --}}
                            <th class="sorting">Coupon Code</th>
                            <th class="sorting">Minimum Sale Amount</th>
                            <th class="sorting">Coupon Amount</th>
                            <th class="sorting">Start Date</th>
                            <th class="sorting">End Date</th>
                            <th class="sorting">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $paginate = $coupons;
                        @endphp

                        @foreach ($coupons as $key => $item)
                            <tr class="odd">
                                <td class="sorting_1">
                                    {{ ($coupons->currentPage() - 1) * $coupons->perPage() + $key + 1 }}
                                </td>
                                <td class="productimgname">
                                    <a href="javascript:void(0);" class="product-img">
                                        <img height=40 style="width:auto" src="{{ asset('frontend/images/coupon/'.$item->banner) }}" alt="product">
                                    </a>
                                    <a href="javascript:void(0);">{{ $item->coupon_name }}</a>
                                </td>
                                {{-- <td>{{$item->category_name}}</td> --}}
                                <td>{{$item->coupon_code}}</td>
                                <td>{{$item->minimum_sale_amount}}</td>
                                <td>
                                    @if($item->type == 1)
                                        {{ number_format($item->amount, 2) }}
                                    @else
                                        {{ $item->amount }}%
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') }}</td>
                                <td>@if($item->status == 1){{"Active"}}@else{{"Invactive"}}@endif</td>
                                <td class="action text-center" data-id="{{ $item->id }}">
                                    <a modalSize="lg" class="me-3 data-edit" data-id="{{ $item->id }}" url="coupons/{{$item->id}}/edit" hideModal="hide" modalTitle="Edit Coupon">
                                        <img src="{{ asset('admin/assets/img/icons/edit.svg') }}" alt="img">
                                    </a>
                                    <a data-id="{{ $item->id }}" url="/coupons/{{$item->id}}" class="me-3 confirm-text delete" href="javascript:void(0);">
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

