<div class="page-header">
    <div class="page-title">
        <h4>Couriers</h4>
        <h6>View/Search Couriers</h6>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Courier" modalSize="md" url="couriers/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Courier
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datanew dataTable">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Client ID</th>
                        <th>API Key</th>
                        <th>API URL</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($couriers as $key => $c)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->client_id }}</td>
                        <td>{{ $c->api_key }}</td>
                        <td>{{ $c->api_url }}</td>
                        <td>{{ $c->status==1 ? 'Active' : 'Inactive' }}</td>
                        <td class="action text-center">
                            <a class="me-3 data-edit" url="couriers/{{$c->id}}/edit" hideModal="hide" modalTitle="Edit Courier">
                                <img src="{{ asset('admin/assets/img/icons/edit.svg') }}" alt="img">
                            </a>
                            <a data-id="{{$c->id}}" url="/couriers/{{$c->id}}" class="me-3 confirm-text delete" href="javascript:void(0);">
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