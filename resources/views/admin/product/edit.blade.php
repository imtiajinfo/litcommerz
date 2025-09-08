<form class="form-load-product-update" type="update" action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Product Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="product_name" placeholder="Product Name" required value="{{$product->product_name}}">
            </div>
        </div>
        <div class="col-lg-2 col-sm-2">
            <div class="form-group">
                <label >Weight</label>
                <input type="text" placeholder="Weight" name="weight" class="form-control" value="{{ $product->weight }}">
            </div>
        </div>
        <div class="col-lg-2 col-sm-2">
            <div class="form-group" id="unit">
                <label>Select Unit</label>
                <select class="form-control" name="unit">
                    <option value="">Unit</option>
                    @foreach ($units as $item)
                        <option @if($product->unit == $item->id){{"selected"}}@endif  value="{{$item->id}}">{{$item->short_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="form-group">
                <label class="required">Buy Price<span class="text-danger">*</span></label>
                <input type="number" step="any" class="form-control" name="buy_price" placeholder="Buy Price" required value="{{$product->buy_price}}" min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="form-group">
                <label class="required">Sell Price<span class="text-danger">*</span></label>
                <input type="number" step="any" class="form-control" name="sell_price" placeholder="Sell Price" required value="{{$product->sell_price}}" min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>

        {{-- <div class="col-lg-4 col-sm-4">
            <div class="form-group">
                <label class="required">Select Category</label>
                <select class="form-control" name="category_id" required id="category-id-edit">
                    <option value="">Select Category</option>
                    @foreach ($categories as $item)
                        <option @if($product->category_id == $item->id){{"selected"}}@endif value="{{$item->id}}">{{$item->category_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="form-group" id="sub_category-edit">
                <label class="required">Select Sub Category</label>
                <select class="form-control" name="subcategory_id">
                    <option value="">Select Sub Category</option>
                    @foreach ($subcategories as $item)
                        <option @if($product->subcategory_id == $item->id){{"selected"}}@endif value="{{$item->id}}">{{$item->subcategory_name}}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}

      <div class="col-12">
          <div id="cat-sub-wrapper">
              @if($product->categories->isEmpty())
              <div class="row align-items-end cat-sub-row mb-2">
                  <div class="col-lg-6">
                      <label class="required">Category<span class="text-danger">*</span></label>
                      <select name="category_ids[]" class="form-control cat-select" required>
                          <option value="">Select Category</option>
                          @foreach($categories as $c)
                          <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-lg-5">
                      <label class="required">Subcategory</label>
                      <select name="subcategory_ids[]" class="form-control subcat-select">
                          <option value="">Select Subcategory</option>
                      </select>
                  </div>
                  <div class="col-lg-1">
                      <button type="button" class="btn btn-success add-row" title="Add row">
                          <i class="fa fa-plus"></i>
                      </button>
                  </div>
              </div>
              @else
              @foreach($product->categories as $index => $category)
              <div class="row align-items-end cat-sub-row mb-2">
                  <div class="col-lg-5">
                      <label class="{{ $index === 0 ? 'required' : '' }}">Category</label>
                      <select name="category_ids[]" class="form-control cat-select" {{ $index === 0 ? 'required' : '' }}>
                          <option value="">Select Category</option>
                          @foreach($categories as $cat)
                          <option value="{{ $cat->id }}" {{ $category->id == $cat->id ? 'selected' : '' }}>
                              {{ $cat->category_name }}
                          </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-lg-4">
                      <label class="">Subcategory</label>
                      <select name="subcategory_ids[]" class="form-control subcat-select">
                          <option value="">Select Subcategory</option>
                          @php
                              $subcategories = \App\Models\SubCategory::where('category_id', $category->id)->get();
                          @endphp
                          @foreach($subcategories as $subcat)
                          <option value="{{ $subcat->id }}" {{ $category->pivot->subcategory_id == $subcat->id ? 'selected' : '' }}>
                              {{ $subcat->subcategory_name }}
                          </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-lg-2">
                      <label>Display No.</label>
                      <input type="number" class="form-control" name="sl[]" value="{{ $category->pivot->sl ?? 0 }}" min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
                  </div>

                  <div class="col-lg-1">
                      @if($index === 0)
                      <button type="button" class="btn btn-success add-row" title="Add row">
                          <i class="fa fa-plus"></i>
                      </button>
                      @else
                      <button type="button" class="btn btn-danger remove-row" title="Remove row">
                          <i class="fa fa-minus"></i>
                      </button>
                      @endif
                  </div>
              </div>
              @endforeach
              @endif
          </div>
      </div>


        <div class="col-lg-6 col-sm-6">
            <div class="form-group" id="brand">
                <label class="required">Select Brand</label>
                <select class="form-control" name="brand">
                    <option value="">Select Brand</option>
                    @foreach ($brands as $brand)
                        <option @if($product->brand == $brand->id){{"selected"}}@endif value="{{$brand->id}}">{{$brand->brand_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6">
            <div class="form-group">
                <label class="required">Available Stock</label>
                <input type="text" class="form-control" name="available_stock" placeholder="Available Stock" value="{{ $product->available_stock }}" required min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>

        {{-- <div class="col-lg-4 col-sm-4">
            <div class="form-group">
                <label class="required">Select Offer</label>
                <select class="form-control" name="offer_id" id="offer-id">
                    <option value="">Select Offer</option>
                    @foreach ($offers as $item)
                        <option @if($product->offer_category_id == $item->id){{"selected"}}@endif value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="form-group">
                <label class="required">Offer Amount</label>
                <input type="number" value="{{ $product->offer_amount }}" class="form-control" name="offer_amount" placeholder="Offer Amount" min="0" oninput="this.value = this.value < 0 ? 0 : this.value">
            </div>
        </div>        --}}
        <div class="col-lg-12 col-sm-12">
            <div class="form-group">
                <label>Note</label>
                <input type="text" placeholder="Note" name="note" class="form-control" value="{{ $product->note }}">
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
                <input type="text" class="form-control" name="image_alt" placeholder="Image Alt Text" value="{{ $product->image_alt }}">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <label for="" class="text-bold mb-2">Description :</label>
            <textarea id="product-add" name="description">{{$product->description}}</textarea>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <label for="" class="text-bold mb-2">Short Description :</label>
            <textarea id="product-short-add" name="short_description">{{$product->short_description}}</textarea>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="" class="text-bold mb-2">Home Show</label>
                <div class="checkbox d-none">
                    <label>
                        <input type="checkbox" @if(isset($special_offer)){{"checked"}}@endif value="1" name="special_offer"> Special Offer
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                    <input type="checkbox" @if(isset($hot_item)){{"checked"}}@endif value="1" name="hot_item"> Hot Item
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                    <input type="checkbox" @if(isset($new_arrival)){{"checked"}}@endif value="1" name="new_arrival"> New Arrival
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label class="required">Status</label>
                <select class="form-control" name="status" id="">
                    <option @if($product->status == 1){{"selected"}}@endif value="1">Active</option>
                    <option @if($product->status == 2){{"selected"}}@endif value="2">Inactive</option>
                </select>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>Slug</label>
                <input type="text" class="form-control" name="slug" placeholder="Custom URL slug (leave empty to auto-generate)" value="{{ $product->slug }}">
            </div>
        </div>

        <!-- Meta Title -->
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" class="form-control" name="meta_title" placeholder="Meta Title" value="{{ $product->meta_title }}">
            </div>
        </div>

        <!-- Meta Description -->
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>Meta Description</label>
                <textarea class="form-control" name="meta_description" rows="3" placeholder="Meta Description">{{ $product->meta_description }}</textarea>
            </div>
        </div>

        <!-- Meta Keywords -->
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>Meta Keywords</label>
                <input type="text" class="form-control" name="meta_keywords" placeholder="Meta Keywords (comma separated)" value="{{ $product->meta_keywords }}">
            </div>
        </div>

        <!-- OG Image -->
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>OG Image [Size: 1200x630 px]</label>
                <img id="ogimg" src="{{ asset('frontend/images/product/og/'.$product->meta_og_image) }}" width="50%">
                <input type="file" name="meta_og_image" class="form-control" oninput="ogimg.src=window.URL.createObjectURL(this.files[0])">
            </div>
        </div>

        <!-- OG Image Alt -->
        <div class="col-lg-12 col-sm-12 col-12">
            <div class="form-group">
                <label>OG Image Alt</label>
                <input type="text" class="form-control" name="meta_og_alt" placeholder="OG Image Alt Text" value="{{ $product->meta_og_alt }}">
            </div>
</div>

    </div>

    <x-admin.modal.update-btn />
    
</form>

<script>
    $('#cat-sub-wrapper')
        .on('click', '.add-row', function () {
            let row = `
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
                    <button type="button" class="btn btn-danger remove-row" title="Remove row">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>`;
            $('#cat-sub-wrapper').append(row);
        })
        .on('click', '.remove-row', function () {
            $(this).closest('.cat-sub-row').remove();
        });

    $('#cat-sub-wrapper').on('change', '.cat-select', function () {
        let row = $(this).closest('.cat-sub-row');
        let categoryId = $(this).val();
        let subSelect = row.find('.subcat-select');
        $.ajax({
            url: "{{ url('category-wise-sub-category') }}/" + categoryId,
            type: 'GET',
            success: function (res) {
                subSelect.html(res);
            }
        });
    });
</script>


<script>
    $(document).ready(function(){
        $("#category-id-edit").change(function(e){
            e.preventDefault();
            let category_id = $(this).val();
            $.ajax({
                type: 'get',
                url: "{{url('category-wise-sub-category')}}/"+category_id,
                dataType: 'html',
                success: function (data) {
                    $("#sub_category-edit").html(data);
                }
            });
        })
    })
    $('#product-short-add').summernote({height:150,minHeight:null,maxHeight:null,focus:true});
    $('#product-add').summernote({height:150,minHeight:null,maxHeight:null,focus:true});
</script>
<script>
    $(function () {
        // $('.product-create-images').imageUploader();
        let preloaded = [
            @foreach ($product_images as $img)
            {id: "{{$img->id}}", src: "{{asset('frontend/images/product/'.$img->image)}}"},
            @endforeach
        ];

        $('.product-create-images').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'images',
            preloadedInputName: 'images',
            maxFiles: 10
        });
    });
</script>


