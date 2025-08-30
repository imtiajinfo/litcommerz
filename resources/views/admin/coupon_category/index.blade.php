<div class="page-header">
    <div class="page-title">
        <h4>Coupon Category list</h4>
        <h6>View/Search Coupon Category</h6>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Coupon Category" modalSize="md" url="coupon_categorys/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Coupon Category
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
                            <th class="sorting">Category name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $paginate = $categories;
                        @endphp

                        @foreach ($categories as $key => $item)
                            <tr class="odd">
                                <td class="sorting_1">
                                    {{ ($categories->currentPage() - 1) * $categories->perPage() + $key + 1 }}
                                </td>
                                <td class="couponimgname">
                                    <a href="javascript:void(0);" class="coupon-img">
                                        <img style="height: 60px" src="{{ asset('frontend/images/coupon/'.$item->image) }}" alt="coupon">
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);">{{ $item->category_name }}</a>
                                </td>
                                <td class="action text-center" data-id="{{ $item->id }}">
                                    <a class="me-3 data-edit" data-id="{{ $item->id }}" url="coupon_categorys/{{$item->id}}/edit" hideModal="hide" modalTitle="Edit Coupon Category">
                                        <img src="{{ asset('admin/assets/img/icons/edit.svg') }}" alt="img">
                                    </a>
                                    <a data-id="{{ $item->id }}" url="/coupon_categorys/{{$item->id}}" class="me-3 confirm-text delete" href="javascript:void(0);">
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

