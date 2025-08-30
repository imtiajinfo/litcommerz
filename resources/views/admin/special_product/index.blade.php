<div class="page-header">
    <div class="page-title">
        <h4>Product list</h4>
        <h6>View/Search product</h6>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalSize="md" modalTitle="Add Special Product" modalSize="lg" url="sepecialProduct/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Special Product
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
                            <th class="sorting">Product name</th>
                            <th class="sorting">Images</th>
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
                                <td>{{ $item->product_name }}</td>
                                <td>
                                    <img src="{{asset('frontend/images/product/'.Helper::product_first_img($item->product_id)->image)}}" style="height: 80px">
                                </td>
                                <td class="action text-center">
                                    <a data-id="{{ $item->id }}" url="/sepecialProduct/{{$item->id}}" class="me-3 confirm-text delete" href="javascript:void(0);">
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


