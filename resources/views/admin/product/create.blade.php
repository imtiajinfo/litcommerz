<form class="form-load" type="create" action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Product Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="product_name" placeholder="Product Name" required>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="form-group">
                <label >Weight</label>
                <input type="text" placeholder="Weight" name="weight" class="form-control">
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="form-group" id="unit">
                <label>Select Unit</label>
                <select class="form-control" name="unit">
                    <option value="">Unit</option>
                    @foreach ($units as $unit)
                        <option value="{{$unit->id}}">{{$unit->short_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 d-none">
            <div class="form-group">
                <label class="required">Buy Price<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="buy_price" placeholder="Buy Price" required min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="form-group">
                <label class="required">Sell Price<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="sell_price" placeholder="Sell Price" required min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>

        <div id="cat-sub-wrapper">
          <div class="row align-items-end cat-sub-row mb-2">
            <div class="col-lg-5">
              <label class="required">Category<span class="text-danger">*</span></label>
              <select name="category_ids[]" class="form-control cat-select" required>
                <option value="">Select Category</option>
                @foreach($categories as $c)
                  <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-4">
              <label class="required">Subcategory</label>
              <select name="subcategory_ids[]" class="form-control subcat-select">
                <option value="">Select Subcategory</option>
              </select>
            </div>
            <div class="col-lg-2">
              <label>Display No.</label>
              <input type="number" name="sl[]" class="form-control" min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
            <div class="col-lg-1">
              <button type="button" class="btn btn-success add-row" title="Add row">
                <i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-sm-6">
            <div class="form-group" id="brand">
                <label class="required">Select Brand</label>
                <select class="form-control" name="brand">
                    <option value="">Select Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6">
            <div class="form-group">
                <label class="required">Opening Stock<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="available_stock" placeholder="Opening Stock" required min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>

        {{-- <div class="col-lg-3 col-sm-3">
            <div class="form-group">
                <label class="required">Select Offer</label>
                <select class="form-control" name="offer_id" id="offer-id">
                    <option value="">Select Offer</option>
                    @foreach ($offers as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}

        {{-- <div class="col-lg-3 col-sm-3">
            <div class="form-group">
                <label class="required">Offer Amount</label>
                <input type="text" class="form-control" name="offer_amount" placeholder="Offer Amount" min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>   --}}
        
        <div class="col-lg-12 col-sm-12">
            <div class="form-group">
                <label>Note</label>
                <input type="text" placeholder="Note" name="note" class="form-control">
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="form-group">
                <label class="required"> Image [Size: 600 * 600 px]<span class="text-danger">*</span></label>
                <div class="product-create-images"></div>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>Image Alt</label>
                <input type="text" class="form-control" name="image_alt" placeholder="Image Alt Text">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <label for="" class="text-bold mb-2">Description :</label>
            <textarea id="product-add" name="description"></textarea>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <label for="" class="text-bold mb-2">Short Description :</label>
            <textarea id="product-short-add" name="short_description"></textarea>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="" class="text-bold mb-2">Home Show</label>
                <div class="checkbox d-none">
                    <label>
                        <input type="checkbox" value="1" name="special_offer"> Special Offer
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                    <input type="checkbox" value="1" name="hot_item"> Hot Item
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                    <input type="checkbox" value="1" name="new_arrival"> New Arrival
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status</label>
                <select class="form-control" name="status" id="">
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>Slug</label>
                <input type="text" class="form-control" name="slug" placeholder="Custom URL slug (leave empty to auto-generate)">
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" class="form-control" name="meta_title" placeholder="Meta Title">
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>Meta Description</label>
                <textarea class="form-control" name="meta_description" rows="3" placeholder="Meta Description"></textarea>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>Meta Keywords</label>
                <input type="text" class="form-control" name="meta_keywords" placeholder="Meta Keywords (comma separated)">
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>OG Image [Size: 1200x630 px]</label>
                <img id="productImg" width="50%">
                <input type="file" name="meta_og_image" class="form-control" oninput="productImg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>OG Image Alt</label>
                <input type="text" class="form-control" name="meta_og_alt" placeholder="OG Image Alt Text">
            </div>
        </div>
        
    </div>

    <x-admin.modal.create-btn />
    
</form>

<script>
    $(document).ready(function(){
        $("#category-id-add").change(function(e){
            e.preventDefault();
            let category_id = $(this).val();
            $.ajax({
                type: 'get',
                url: "{{url('category-wise-sub-category')}}/"+category_id,
                dataType: 'html',
                success: function (data) {
                    $("#sub_category-add").html(data);
                }
            });
        })
    })

    $('#product-add').summernote({height:150,minHeight:null,maxHeight:null,focus:true});
    $('#product-short-add').summernote({height:150,minHeight:null,maxHeight:null,focus:true});
</script>

<script>
  $('#cat-sub-wrapper')
    .on('click', '.add-row', function() {
      let $row = $(this).closest('.cat-sub-row');
      let $clone = $row.clone();

      $clone.find('select').val('');

      $clone.find('.add-row')
        .removeClass('btn-success add-row')
        .addClass('btn-danger remove-row')
        .html('<i class="fa fa-minus"></i>');

      $('#cat-sub-wrapper').append($clone);
    })
    .on('click', '.remove-row', function() {
      $(this).closest('.cat-sub-row').remove();
    });

  $('#cat-sub-wrapper').on('change', '.cat-select', function() {
    let $row = $(this).closest('.cat-sub-row');
    let catId = $(this).val();
    let $subSel = $row.find('.subcat-select');

    $.ajax({
      url: "{{ url('category-wise-sub-category') }}/" + catId,
      type: 'GET',
      dataType: 'html',
      success: function(html) {
        $subSel.html(html);
      }
    });
  });
</script>

<script>
    $(function () {
        $('.product-create-images').imageUploader();
    });
</script>


