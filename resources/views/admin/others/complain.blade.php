<div class="page-header">
    <div class="page-title">
        <h4>Comment list</h4>
        <h6>View/Search Comment</h6>
    </div>
    <div class="page-btn">
    
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
                            <th class="sorting">Date</th>
                            <th class="sorting">Name</th>
                            <th class="sorting">Email</th>
                            <th class="sorting">Phone</th>
                            <th class="sorting">Order No</th>
                            <th class="sorting">Inquery Subject</th>
                            <th class="sorting">Message</th>
                            <th class="sorting">Image</th>
                            <th class="sorting">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $paginate = $complains;
                        @endphp

                        @foreach ($complains as $key => $item)
                            <tr class="odd">
                                <td class="sorting_1">
                                    {{ ($complains->currentPage() - 1) * $complains->perPage() + $key + 1 }}
                                </td>
                                <td>{{date('d M,y H:i A', strtotime($item->created_at))}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->phone}}</td>
                                <td>{{$item->order_no}}</td>
                                <td>{{$item->inquery}}</td>
                                <td>
                                    {{ Str::limit($item->message, 50) }}
                                    @if (Str::length($item->message) > 50)
                                        <a href="#" class="badge bg-success text-white" data-bs-toggle="modal" data-bs-target="#viewMessageModal{{ $item->id }}">
                                            More
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if($item->image)
                                        <img src="{{asset('frontend/images/complain-form/'.$item->image)}}" alt="" style="height: 60px">
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->status == 0)
                                    <form class="form-load" type="update" action="{{ route('admin.complain.mark-read') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-sm btn-warning">Mark as Read</button>
                                    </form>
                                    @else
                                        <span class="badge bg-success">Read</span>
                                    @endif
                                </td>
                                <div class="modal fade" id="viewMessageModal{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $item->id }}">Full Message</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $item->message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                
                @include('components.admin.pagination')
                
            </div>
        </div>

    </div>
</div>

