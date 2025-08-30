<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <table class="table datanew dataTable no-footer" id="DataTables_Table_0" role="grid"
                    aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting text-center">Sl</th>
                            <th class="sorting text-center">OrderId</th>
                            <th class="sorting text-center">Date</th>
                            <th class="sorting text-center">Name</th>
                            <th class="sorting text-center">Email</th>
                            <th class="sorting text-center">Total Pro</th>
                            <th class="sorting text-center">Total</th>
                            <th class="sorting text-center">Coupon</th>
                            <th class="sorting text-center">Payable</th>
                            <th class="sorting text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $paginate = $orders;
                        @endphp

                        @foreach ($orders as $key => $item)
                            <tr class="odd border">
                                <td class="text-center sorting_1">
                                    {{-- {{ ($orders->currentPage() - 1) * $orders->perPage() + $key + 1 }} --}}
                                    {{ $key + 1 }}
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0);">#{{ $item->id }}</a>
                                </td>
                                <td class="text-center">{{date('d M,y H:i A', strtotime($item->created_at))}}</td>
                                <td class="text-center">@if(@$item->user->name){{@$item->user->name}}@else{{"Guest"}}@endif</td>
                                <td class="text-center">@if(@$item->user->email){{@$item->user->email}}@else{{"Guest"}}@endif</td>
                                <td class="text-center">{{$item->total_product}}</td>
                                <td class="text-center">{{$item->total_amount}}</td>
                                <td class="text-center">{{$item->coupon}}</td>
                                <td class="text-center">{{$item->payeble_amount}}</td>
                                <td class="text-center" data-id="{{ $item->id }}">

                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                          Action
                                        </button>
                                        <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton1">
                                            <li class="border border-bottom-1"><a class="fw-bold dropdown-item me-3 btn btn-info mb-1 btn-sm" href="{{ url('admin/invoice/'.$item->id) }}" target="_blank">
                                                Invoice Print
                                            </a></li>
                                            
                                            <li class="border border-bottom-1"><a class="fw-bold dropdown-item me-3 btn btn-info mb-1 btn-sm" href="{{ url('admin/invoice-pdf/'.$item->id) }}">
                                                Invoice PDF
                                            </a></li>

                                        </ul>
                                    </div>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                
                
            </div>
        </div>

    </div>
</div>

