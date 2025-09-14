<div class="page-header">
    <div class="page-title">
        <h4>Payment Gateways</h4>
        <h6>View/Search Payment Gateways</h6>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Payment Gateway" modalSize="md" url="paymentGateways/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Payment Gateway
        </a>
    </div>
</div>

@csrf

<div class="card">
    <div class="card-body">
        <div class="table-top">
            <div class="wordset">
                <ul>
                    <li>
                    </li>
                    <li>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <table class="table datanew dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting">Sl</th>
                            <th class="sorting">Name</th>
                            <th class="sorting">Mode</th>
                            <th class="sorting">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gateways as $key => $gateway)
                        <tr class="odd">
                            <td class="sorting_1">
                                {{ $key + 1 }}
                            </td>
                            <td>{{ $gateway->name }}</td>
                            <td>{{ ucfirst($gateway->mode) }}</td>
                            <td>@if($gateway->status == 1){{ "Active" }}@else{{ "Inactive" }}@endif</td>
                            <td class="action text-center" data-id="{{ $gateway->id }}">
                                <a class="me-3 data-edit" data-id="{{ $gateway->id }}" url="paymentGateways/{{$gateway->id}}/edit" hideModal="hide" modalTitle="Edit Payment Gateway">
                                    <img src="{{ asset('admin/assets/img/icons/edit.svg') }}" alt="img">
                                </a>
                                <a data-id="{{ $gateway->id }}" url="/paymentGateways/{{$gateway->id}}" class="me-3 confirm-text delete" href="javascript:void(0);">
                                    <img src="{{ asset('admin/assets/img/icons/delete.svg') }}" alt="img">
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
