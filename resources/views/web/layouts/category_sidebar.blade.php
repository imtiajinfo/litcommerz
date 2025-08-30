<ul id="headerSidebarList" class="u-header-collapse__nav">
    <li>
        <div class="dropdown-title u-header-collapse__nav-link mb-2" style="margin-left: 30px;font-size:1rem">Categories</div>
    </li>
    @foreach (Helper::sidebarCategory_offers() as $item)
        
        <li>
            <a class="u-header-collapse__nav-link @if(url()->current() == url('spcial-offers/'.$item->slug)) text-blue category-active @endif" href="{{url('spcial-offers/'.$item->slug)}}" role="button"> <img style="height:33px;border-radius:5px;margin-left:20px;padding:4px" src="{{ asset('frontend/images/offer/'.$item->banner) }}" alt="{{ $item->name }}">&nbsp;{{ $item->name }}</a>
        </li>
    @endforeach

    @foreach (Helper::sidebarCategories() as $category)

        @if(count($category->sub_categories) != 0)

            <li class="u-has-submenu u-header-collapse__submenu">

                <a class="u-header-collapse__nav-link @if(url()->current() == url('category/'.$category->slug)) text-blue category-active @endif" href="{{url('category/'.$category->slug)}}"> <img style="height:33px;border-radius:5px;margin-left:20px;padding:4px" src="{{ asset('frontend/images/category/'.$category->image) }}" alt="{{ $category->category_name }}">&nbsp;{{ $category->category_name }}</a>
                
                <a class="u-header-collapse__nav-link u-header-collapse__nav-pointer sidebar-category-icon" href="#" data-target="#headerSidebarCacategoryCollapse-{{$category->id}}" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="headerSidebarCacategoryCollapse-{{$category->id}}"></a>

                @php
                    $checkurl = [];
                    foreach ($category->sub_categories as $item){
                        array_push($checkurl, (url('sub-category/'.$item->slug)));
                    }
                @endphp
                <div id="headerSidebarCacategoryCollapse-{{$category->id}}" class="collapse @if((url()->current() == url('category/'.$category->slug)) || (in_array(url()->current(), $checkurl))) show @endif u-header-collapse__nav-list-parent" data-parent="#headerSidebarContent">
                    <ul class="u-header-collapse__nav-list">

                        @foreach ($category->sub_categories as $item)
                            <li><a class="u-header-collapse__nav-link @if(url()->current() == url('sub-category/'.$item->slug)) text-blue category-active @endif" href="{{url('sub-category/'.$item->slug)}}"><img style="height:33px;border-radius:5px;margin-left:20px" src="{{ asset('frontend/images/subcategory/'.$item->image) }}" alt="{{ $category->subcategory_name }}">&nbsp;{{$item->subcategory_name}}<span class="text-gray-25 font-size-12 font-weight-normal"></span></a></li>
                        @endforeach

                    </ul>
                </div>
            </li>

        @else
            <li>
                <a class="u-header-collapse__nav-link @if(url()->current() == url('category/'.$category->slug)) text-blue category-active @endif" href="{{url('category/'.$category->slug)}}" role="button"> <img style="height:33px;border-radius:5px;margin-left:20px;padding:4px" src="{{ asset('frontend/images/category/'.$category->image) }}" alt="{{ $category->category_name }}">&nbsp;{{ $category->category_name }}</a>
            </li>
        @endif
    @endforeach

</ul>