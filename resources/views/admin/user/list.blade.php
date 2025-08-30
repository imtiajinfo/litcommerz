<div class="page-header">
    <div class="page-title">
        <h4>User list</h4>
        <h6>View/Search User</h6>
    </div>
    <div class="page-btn">
        <a href="javascript:void(0);" 
            class="btn btn-added show-modal" 
            hideModal="hide" 
            modalTitle="Add New User" 
            modalSize="md" 
            url="user/create">
            <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add User
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
                            <th class="sorting">CustomerID</th>
                            <th class="sorting">Name</th>
                            <th class="sorting">Email</th>
                            <th class="sorting">Total Point</th>
                            <th class="sorting">User Type</th>
                            {{-- <th class="sorting">Verified</th> --}}
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $paginate = $users;
                        @endphp

                        @foreach ($users as $key => $item)
                            <tr class="odd">
                                <td class="sorting_1">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $key + 1 }}
                                </td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    {{$item->points()->sum('point')}}
                                </td>
                                <td>
                                    @if($item->role == 0)
                                        {{"User"}}
                                    @else
                                        {{$item->roles->role_name ?? ''}}
                                    @endif
                                </td>
                                {{-- <td>
                                    @if($item->verified == 1)
                                        {{"Verified"}}
                                    @else
                                        {{"Not Verified"}}
                                    @endif
                                </td> --}}
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                            <li class="border border-bottom-1">
                                                <a class="fw-bold dropdown-item btn btn-primary btn-sm show-modal"
                                                  type="show"
                                                  data-id="{{ $item->id }}"
                                                  url="details-info?user_id={{ $item->id }}"
                                                  modalSize="lg"
                                                  hideModal="hide"
                                                  modalTitle="Details Information - [{{ $item->name }}]">
                                                  Details
                                                </a>
                                            </li>

                                            <li class="border border-bottom-1">
                                                <a class="fw-bold dropdown-item btn btn-success btn-sm show-modal"
                                                  type="show"
                                                  data-id="{{ $item->id }}"
                                                  url="all-orders?user_id={{ $item->id }}"
                                                  modalSize="xl"
                                                  hideModal="hide"
                                                  modalTitle="Orders - [{{ $item->name }}]">
                                                  Orders
                                                </a>
                                            </li>

                                            <li class="border border-bottom-1">
                                                <a class="fw-bold dropdown-item btn btn-info btn-sm show-modal"
                                                  type="show"
                                                  data-id="{{ $item->id }}"
                                                  url="user/edit-role?user_id={{ $item->id }}&role={{ $item->role }}"
                                                  modalSize="md"
                                                  hideModal="hide"
                                                  modalTitle="Edit - [{{ $item->name }}]">
                                                  Edit
                                                </a>
                                            </li>

                                            <li class="border border-bottom-1">
                                                <a class="fw-bold dropdown-item btn btn-warning btn-sm show-modal"
                                                  type="show"
                                                  data-id="{{ $item->id }}"
                                                  url="user/change-password?user_id={{ $item->id }}"
                                                  modalSize="md"
                                                  hideModal="hide"
                                                  modalTitle="Change Password - [{{ $item->name }}]">
                                                  Password
                                                </a>
                                            </li>

                                            <li class="border border-bottom-1">
                                                <form method="POST" class="form-load m-0" action="{{ route('admin.user.delete', $item->id) }}" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                                        Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
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

