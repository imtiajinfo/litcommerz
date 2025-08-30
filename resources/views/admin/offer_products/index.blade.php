<div class="page-header">
    <div class="page-title">
        <h4>Offer Product list</h4>
        <h6>View/Search Offer Product</h6>
    </div>
    <div class="page-btn d-flex gap-2">
         <a class="btn btn-added anchor" href="offers">
            Back To List
        </a>
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Offer Product" modalSize="lg" url="offer_products/create?offer_id={{$offer_id}}">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Offer Product
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
                            <th class="sorting">Product Name</th>
                            <th class="sorting">Is Amount/Percentage</th>
                            <th class="sorting">Amount/Percentage</th>
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
                                        <img height=80 src="{{ asset('frontend/images/product/'.Helper::product_first_img($item->product_id)->image) }}" alt="product">
                                    </a>
                                </td>
                                <td>{{$item->product_name}}</td>
                                <td>
                                    @if($item->is_percentage == 1)
                                        {{"Percentage"}}
                                    @else
                                        {{"Amount"}}
                                    @endif
                                </td>
                                <td>
                                    @if($item->is_percentage == 1)
                                        {{$item->percentage}}% 
                                    @else
                                        {{$item->amount}}
                                    @endif
                                </td>
                                <td class="action text-center" data-id="{{ $item->id }}">
                                    <a class="me-3 data-edit" data-id="{{ $item->id }}" modalSize="lg" url="offer_products/{{$item->id}}/edit?product_id={{$item->product_id}}" hideModal="hide" modalTitle="Edit Offer Product">
                                        <img src="{{ asset('admin/assets/img/icons/edit.svg') }}" alt="img">
                                    </a>
                                    <a data-id="{{ $item->id }}" url="/offer_products/{{$item->id}}" class="me-3 confirm-text delete" href="javascript:void(0);">
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

