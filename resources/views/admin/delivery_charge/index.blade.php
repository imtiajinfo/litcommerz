<div class="page-header">
    <div class="page-title">
        <h4>Delivery Charge List</h4>
        <h6>View/Search Delivery Charges</h6>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Delivery Charge" modalSize="md" url="delivery-charges/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1">Add Delivery Charge
        </a>
    </div>
</div>

@php $paginate = $deliveryCharges; @endphp

@csrf
<div class="card">
    <div class="card-body">
        @include('components.admin.search')
        <div class="table-responsive">
            <table class="table datanew">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Region</th>
                        <th>City</th>
                        <th>Charge</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deliveryCharges as $key => $item)
                    <tr>
                        <td>
                         {{ ($deliveryCharges->currentPage() - 1) * $deliveryCharges->perPage() + $key + 1 }}
                        </td>
                        <td>{{ $item->region->name ?? '' }}</td>
                        <td>{{ $item->city }}</td>
                        <td>{{ number_format($item->charge, 2) }}</td>
                        <td class="text-center">
                            <a class="me-3 data-edit" data-id="{{ $item->id }}" url="delivery-charges/{{$item->id}}/edit" hideModal="hide" modalTitle="Edit Delivery Charge">
                                <img src="{{ asset('admin/assets/img/icons/edit.svg') }}">
                            </a>
                            <a data-id="{{ $item->id }}" url="/delivery-charges/{{$item->id}}" class="me-3 confirm-text delete" href="javascript:void(0);">
                                <img src="{{ asset('admin/assets/img/icons/delete.svg') }}">
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
