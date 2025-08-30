<label class="required">Select Product</label>
<select name="" id="addNewProduct" class="form-select">
    {{-- <option value="">Add New Product</option> --}}
    @foreach ($products as $item1)
    <option value="{{ json_encode($item1) }}">{{ $item1->product_name }}</option>
    @endforeach
</select>