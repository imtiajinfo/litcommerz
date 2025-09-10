@php
$setting = Helper::setting();
@endphp

<div class="page-header">
    <div class="page-title">
        <h4>Order list</h4>
        <h6>View/Search Order</h6>
    </div>
    <div class="page-btn">
    
    </div>
</div>

@csrf

<div class="card">
    <div class="card-body">
        <div class="table-top">

            @include('components.admin.search')
            @include('components.admin.datefilter')

            <div class="wordset">
                <ul>
                    <li>
                        <select name="status" onchange="change(this.value, 'status')" class="form-control form-select custom-select custom-select-sm">
                            <option @if(@$status == 'all'){{"selected"}}@endif value="all">All Order</option>
                            <option @if(@$status == 'pending'){{"selected"}}@endif value="pending">Pending</option>
                            <option @if(@$status == 'confirmed'){{"selected"}}@endif value="confirmed">Confirmed</option>
                            <option @if(@$status == 'preparing'){{"selected"}}@endif value="preparing">Preparing</option>
                            <option @if(@$status == 'verifying'){{"selected"}}@endif value="verifying">Verifying</option>
                            <option @if(@$status == 'ready'){{"selected"}}@endif value="ready">Ready For Delivary</option>
                            <option @if(@$status == 'on-the-way'){{"selected"}}@endif value="on-the-way">On The Way</option>
                            <option @if(@$status == 'near'){{"selected"}}@endif value="near">Nearist</option>
                            <option @if(@$status == 'complete'){{"selected"}}@endif value="complete">Delivered</option>
                            <option @if(@$status == 'cancel'){{"selected"}}@endif value="cancel">Cancelled</option>
                        </select>
                    </li>
                    <li>
                        @include('components.admin.perpage')
                    </li>
                    <li>
                        {{-- <x-admin.print-button /> --}}
                    </li>
                    <li>
                        <a href="orders" class="btn btn-primary anchor">
                          <i class="fas fa-sync-alt"></i>
                      </a>
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
                            <th class="sorting text-center">Sl</th>
                            <th class="sorting text-center">OrderId</th>
                            <th class="sorting text-center">Date</th>
                            <th class="sorting text-center">Name</th>
                            <th class="sorting text-center">Email</th>
                            <th class="sorting text-center">Total Pro</th>
                            <th class="sorting text-center">Total</th>
                            <th class="sorting text-center">Coupon</th>
                            {{-- <th class="sorting text-center">Discount</th> --}}
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
                                    {{ ($orders->currentPage() - 1) * $orders->perPage() + $key + 1 }}
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
                                {{-- <td class="text-center">{{$item->discount}}</td> --}}
                                <td class="text-center">{{$item->payeble_amount}}</td>
                                <td class="text-center" data-id="{{ $item->id }}">

                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                          Action
                                        </button>
                                        <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton1">
                                            <li class="border border-bottom-1 text-center fw-bold "><a class="me-3 mb-1 btn-sm dropdown-item @if($item->track_status==5 || $item->track_status==6)@else data-edit @endif btn @if($item->track_status==5)text-success @elseif($item->track_status==6) text-danger @else text-primary @endif text-sm" data-id="{{ $item->id }}" url="orders/{{$item->id}}/edit" hideModal="hide" modalTitle="Order Track Status [#{{ $item->id }}]"><b>Status : 

                                                @if($item->track_status==0){{"Pending"}}
                                                @elseif($item->track_status==1){{"Confirm"}}
                                                @elseif($item->track_status == 7){{"Preparing"}}
                                                @elseif($item->track_status == 8){{"Verifying"}}
                                                @elseif($item->track_status==2){{"Ready For Delivary"}}
                                                @elseif($item->track_status==3){{"On The Way"}}
                                                @elseif($item->track_status==4){{"Nearist"}}
                                                @elseif($item->track_status==5){{"Delivered"}}
                                                @elseif($item->track_status==6){{"Cancelled"}}@endif</b>
                                            </a></li>

                                            <li class="border border-bottom-1">
                                                <a class="fw-bold dropdown-item me-3 btn btn-warning mb-1 btn-sm" 
                                                  href="{{ url('admin/purchase-invoice/'.$item->id) }}" target="_blank">
                                                    Buy Price PDF
                                                </a>
                                            </li>

                                            <li class="border border-bottom-1"><a class="fw-bold dropdown-item me-3 mb-1 btn-sm btn btn- show-modal" type="show" data-id="{{ $item->id }}" url="orders/{{$item->id}}?status=1" modalSize="md" hideModal="hide" modalTitle="Shipping Info [#{{ $item->id }}]">
                                                Shipping Info
                                            </a></li>
        
                                            <li class="border border-bottom-1"><a class="fw-bold dropdown-item me-3 mb-1 btn btn-info show-modal btn-sm" type="show" data-id="{{ $item->id }}" url="orders/{{$item->id}}?status=2" modalSize="xl" hideModal="hide" modalTitle="Products [#{{ $item->id }}]">
                                                Products
                                            </a></li>
        
                                            <li class="border border-bottom-1 d-none"><a class="fw-bold dropdown-item me-3 btn btn-info mb-1 btn-sm" href="{{ url('admin/invoice/'.$item->id) }}" target="_blank">
                                                Invoice Print
                                            </a></li>
                                            
                                            <li class="border border-bottom-1"><a class="fw-bold dropdown-item me-3 btn btn-info mb-1 btn-sm" href="{{ url('admin/invoice-pdf/'.$item->id) }}">
                                                Invoice Download
                                            </a></li>

                                            @if ($item->track_status != 5 && $item->track_status != 6)
                                            <li class="border border-bottom-1"><a class="fw-bold dropdown-item me-3 mb-1 btn btn-info show-modal btn-sm" type="show" data-id="{{ $item->id }}" url="orders-edit/{{$item->id}}" modalSize="xl" hideModal="hide" modalTitle="Order Edit [#{{ $item->id }}]">
                                                Edit
                                            </a></li>
                                            @endif

                                        </ul>
                                    </div>

                                </td>

                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6" class="text-end fw-bold">Total:</td>
                            <td class="text-center fw-bold">{{ $setting->currency_icon }}{{ $totalSum }}</td>
                            <td colspan="3"></td>
                        </tr>

                    </tbody>
                </table>
                
                @include('components.admin.pagination')
                
            </div>
        </div>

    </div>
</div>

