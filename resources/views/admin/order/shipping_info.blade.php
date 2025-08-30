<div class="row">
    <div class="col-12 d-flex">
        <div class="card flex-fill bg-white">
            <div class="card-body">
                <p class="card-text">
                    @if($order->is_shipping == 1)
                        Name     : {{$ship->name}}<br>
                        Email    : {{$ship->email}}<br>
                        Address  : {{$ship->address}}<br>
                        Apt Suite: {{$ship->apt_suite}}<br>
                        Prefecture: {{$ship->prefecture ?? ''}}<br>
                        City     : {{$ship->city}}<br>
                        Postcode : {{$ship->postcode}}<br>
                        Phone    : {{$ship->phone}}<br>
                    @else
                        @php
                            $userInfo = json_decode($order->shipping_info->user_info);
                            $shippingInfo = json_decode($order->shipping_info->shipping_info);
                            $ship = $shippingInfo;
                        @endphp
                        Name     : {{$ship->name}}<br>
                        Email    : {{$ship->email}}<br>
                        Address  : {{$ship->address}}<br>
                        Apt Suite: {{$ship->apt_suite}}<br>
                        Prefecture: {{$ship->prefecture ?? ''}}<br>
                        City     : {{$ship->city}}<br>
                        Postcode : {{$ship->postcode}}<br>
                        Phone    : {{$ship->phone}}<br>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
