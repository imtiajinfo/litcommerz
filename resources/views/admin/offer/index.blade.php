<div class="page-header">
    <div class="page-title">
        <h4>Offer list</h4>
        <h6>View/Search Offer</h6>
    </div>
    <div class="page-btn d-flex d-inline">
        <a href="offer-sorting" class="btn btn-added anchor">
            <img src="{{ asset('admin/assets/img/icons/transfer1.svg') }}" class="me-1" alt="img">Sorting
        </a>&nbsp;&nbsp;
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Offer" modalSize="lg" url="offers/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Offer
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
                            <th class="sorting">Image</th>
                            <th class="sorting">Offer Title</th>
                            <th class="sorting">Start Date</th>
                            <th class="sorting">End Date</th>
                            <th class="sorting">Status</th>
                            <th class="sorting">Home Show</th>
                            <th class="sorting">Offer Product</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $paginate = $offers;
                        @endphp

                        @foreach ($offers as $key => $item)
                            <tr class="odd">
                                <td class="sorting_1">
                                    {{ ($offers->currentPage() - 1) * $offers->perPage() + $key + 1 }}
                                </td>
                                
                                <td class="productimgname">
                                    <a href="javascript:void(0);" class="product-img">
                                        <img height=80 src="{{ asset('frontend/images/offer/'.$item->banner) }}" alt="product">
                                    </a>
                                </td>
                                <td>{{$item->name}}</td>
                                <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') }}</td>
                                <td>@if($item->status == 1){{"Active"}}@else{{"Invactive"}}@endif</td>
                                <td>@if($item->home_show == 1){{"Yes"}}@else{{"No"}}@endif</td>
                                <td>
                                    <a class="btn btn-info anchor" href="offer_products?offer_id={{$item->id}}">Products</a>
                                </td>
                                <td class="action text-center" data-id="{{ $item->id }}">
                                    <a class="me-3 data-edit" data-id="{{ $item->id }}" modalSize="lg" url="offers/{{$item->id}}/edit" hideModal="hide" modalTitle="Edit Offer">
                                        <img src="{{ asset('admin/assets/img/icons/edit.svg') }}" alt="img">
                                    </a>
                                    <a data-id="{{ $item->id }}" url="/offers/{{$item->id}}" class="me-3 confirm-text delete" href="javascript:void(0);">
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

