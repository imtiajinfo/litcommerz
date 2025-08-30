<form class="form-load" type="update" action="{{ route('admin.orders.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status</label>
                <select class="form-control" name="status" id="">
                    @if(($order->track_status == 5) || ($order->track_status == 6))@else
                        <option @if($order->track_status == 1){{"selected"}}@endif value="1">Confirm</option>
                        <option @if($order->track_status == 7){{"selected"}}@endif value="7">Preparing</option>
                        <option @if($order->track_status == 8){{"selected"}}@endif value="8">Verifying</option>
                        <option @if($order->track_status == 2){{"selected"}}@endif value="2">Ready For Delivary</option>
                        <option @if($order->track_status == 3){{"selected"}}@endif value="3">On The Way</option>
                        <option @if($order->track_status == 4){{"selected"}}@endif value="4">Nearist</option>
                    @endif
                    <option @if($order->track_status == 5){{"selected"}}@endif value="5">Delivered</option>
                    <option @if($order->track_status == 6){{"selected"}}@endif value="6">Cancelled</option>
                </select>
            </div>
        </div>
    </div>

    <x-admin.modal.update-btn />
    
</form>