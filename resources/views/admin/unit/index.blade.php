<div class="page-header">
    <div class="page-title">
        <h4>Unit list</h4>
        <h6>View/Search Unit</h6>
    </div>
    <div class="page-btn">
        <a href="#" class="btn btn-added show-modal" hideModal="hide" modalTitle="Add Unit" modalSize="md" url="units/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Unit
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
                <table class="table datanew dataTable no-footer" id="DataTables_Table_0" unit="grid"
                    aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr unit="row">
                            <th class="sorting">Sl</th>
                            <th class="sorting">Unit name</th>
                            <th class="sorting">Short name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $paginate = $units;
                        @endphp

                        @foreach ($units as $key => $item)
                            <tr class="odd">
                                <td class="sorting_1">
                                    {{ ($units->currentPage() - 1) * $units->perPage() + $key + 1 }}
                                </td>
                                <td>
                                    {{ $item->unit_name }}
                                </td>
                                <td>
                                    {{ $item->short_name }}
                                </td>
                                <td class="action text-center" data-id="{{ $item->id }}">
                                    <a class="me-3 data-edit" data-id="{{ $item->id }}" url="units/{{$item->id}}/edit" hideModal="hide" modalTitle="Edit unit">
                                        <img src="{{ asset('admin/assets/img/icons/edit.svg') }}" alt="img">
                                    </a>
                                    <a data-id="{{ $item->id }}" url="/units/{{$item->id}}" class="me-3 confirm-text delete" href="javascript:void(0);">
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

