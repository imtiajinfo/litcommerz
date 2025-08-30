<form class="form-load" type="create" action="{{ route('admin.coupons.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        {{-- <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Select Category</label>
                <select class="form-control" name="category" id="">
                    <option value="">Select</option>
                    @foreach ($categories as $item)
                        <option value="{{$item->id}}">{{$item->category_name}}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Coupon Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="coupon_name" placeholder="Coupon Name" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Coupon Code<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="coupon_code" placeholder="Coupon Code" required>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 900 * 330 px]<span class="text-danger">*</span></label>
                <img id="couponImg" width="50%" width="50%">
                <input type="file" name="image" class="form-control" oninput="couponImg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Coupon Type<span class="text-danger">*</span></label>
                <select class="form-control" name="type" id="couponType" required>
                    <option value="1">Fixed Amount</option>
                    <option value="2">Percentage</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Minimum Sale Amount<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="minimum_sale_amount" placeholder="Minimum Sale Amount" required min="1" oninput="this.value = this.value < 1 ? 1 : this.value">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Coupon Amount<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="amount" placeholder="Amount" required min="1" oninput="this.value = this.value < 1 ? 1 : this.value">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Start Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="start_date" placeholder="Start Date" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">End Date<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="end_date" placeholder="End Date" required>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status<span class="text-danger">*</span></label>
                <select class="form-control" name="status" id="">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
        </div>
        
    </div>

    <x-admin.modal.create-btn />
    
</form>


