<form class="form-load" type="update" action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        {{-- <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Select Category</label>
                <select class="form-control" name="category" id="">
                    <option value="">Select</option>
                    @foreach ($categories as $item)
                        <option @if($coupon->category_id == $item->id){{"selected"}}@endif value="{{$item->id}}">{{$item->category_name}}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Coupon Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="coupon_name" placeholder="Coupon Name" required value="{{$coupon->name}}">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Coupon Code<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="coupon_code" placeholder="Coupon Code" required value="{{$coupon->coupon_code}}">
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 900 * 330 px]<span class="text-danger">*</span></label>
                <img id="categoryimg" src="{{asset('frontend/images/coupon/'.$coupon->banner)}}" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="categoryimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Coupon Type<span class="text-danger">*</span></label>
                <select class="form-control" name="type" id="couponType" required>
                    <option value="1" @if($coupon->type == 1) selected @endif>Fixed Amount</option>
                    <option value="2" @if($coupon->type == 2) selected @endif>Percentage</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Minimum Sale Amount<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="minimum_sale_amount" placeholder="Minimum Sale Amount" required value="{{$coupon->minimum_sale_amount}}" min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Coupon Amount<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="amount" placeholder="Amount" required value="{{$coupon->amount}}" min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Start Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="start_date" placeholder="Start Date" required value="{{$coupon->start_date}}">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">End Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="end_date" placeholder="End Date" required value="{{$coupon->end_date}}">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" id="">
                    <option @if($coupon->status == 1){{"selected"}}@endif value="1">Active</option>
                    <option @if($coupon->status == 2){{"selected"}}@endif value="2">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <x-admin.modal.update-btn />
    
</form>