@php
$setting = Helper::setting();
@endphp

<div class="page-header">
    <div class="page-title">
        <h4>Zone list</h4>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Zone" modalSize="md" url="regions/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1">Add Zone
        </a>
    </div>
</div>
@csrf
<div class="card">
    <div class="card-body">
        @include('components.admin.search')
        <div class="table-responsive">
            <table class="table datanew">
                <thead>
                    <tr>
                        <th class="sorting">Sl</th>
                        <th class="sorting">Zone</th>
                        <th class="sorting">Delivery Charge ({{ $setting->currency_icon }})</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($regions as $key => $item)
                        <tr>
                            <td class="sorting">
                              {{ $key + 1 }}
                            </td>
                            <td class="sorting">{{ $item->name }}</td>
                            <td class="sorting">{{ $item->delivery_charge }}</td>
                            <td class="text-center">
                                <a class="me-3 data-edit" data-id="{{ $item->id }}" url="regions/{{$item->id}}/edit" hideModal="hide" modalTitle="Edit Zone">
                                    <img src="{{ asset('admin/assets/img/icons/edit.svg') }}">
                                </a>
                                <a data-id="{{ $item->id }}" url="/regions/{{$item->id}}" class="me-3 confirm-text delete" href="javascript:void(0);">
                                    <img src="{{ asset('admin/assets/img/icons/delete.svg') }}">
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>