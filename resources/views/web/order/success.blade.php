@extends('web.layouts.master')

@section('title', 'Order Success'.$id.' - My Daily Shop')

@php
$setting = Helper::setting();
@endphp

@section('main')

<!-- breadcrumb -->
<div class="bg-gray-13 bg-md-transparent">
    <div class="container">
        <!-- breadcrumb -->
        <div class="my-md-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="/">Home</a></li>
                    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Orders</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb -->
    </div>
</div>
<!-- End breadcrumb -->

<div class="container">
    <!-- start of nav -->

  <!-- start of main -->
  <div style="background:">
  <div class="container">
  
    <div class="row">
      <div class="col-12 ">
        <div class="message-box">
          <div class="success-container">
            <br>
            <img src="https://fcs3pub.s3.amazonaws.com/photo-book/images/payment/success.gif" alt="" style="height: 15vh;">
            <br>
            <div class="confirm-green-box p-3">
              <h5 style="font-weight: bold;">Order Placed Successfully!</h5>
              <h5 style="font-weight: 400;">Order No: #{{$id}}</h5>
              <h5 style="font-weight: 400;">Thank you for for your purchase</h5>
            </div>
            <br>
            <a target="_blank" href="/invoice/{{$id}}" class="btn btn-primary">Get Invoice</a>
            <a target="_blank" href="/shop" id="create-btn" class="btn btn-secondary margin-left-5px">New-Order</a>
          </div>
        </div>
      </div>
    </div>
  
  </div>
  </div>
  <!-- end of main -->
</div>

<style>
    /* Write page CSS here*/
.message-box{
  display: flex;
  justify-content: center;
  padding-bottom: 20vh;
}
.success-container{
  background: white;
  height: 550px;
  width: 90%;
box-shadow: 5px 5px 10px grey;
  text-align: center;
}
.confirm-green-box{
  width: 100%;
  height: 140px;
  background: #d7f5da;
}


.monserrat-font{
  font-family: 'Montserrat', sans-serif;
  letter-spacing: 2px;
}





/* --------------- site wide START ----------------- */
.main{
  width:80vw;
  margin: 0 10vw;
  height:50vh;
  overflow:hidden;
  
}

body{
  font-family: 'Montserrat', sans-serif;
}

/* 
 * Setting the site variables, example of how to use
 * color:var(--text-1);
 *
 */

:root {
    --background-1: #ffffff;
    --background-2: #E3E3E3;
    --background-3: #A3CCC8;
    --text-1: #000000;
    --text-2: #ffffff;
    --text-size-reg: calc(20px + (20 - 18) * ((100vw - 300px) / (1600 - 300)));
    --text-size-sml: calc(10px + (10 - 8) * ((100vw - 300px) / (1600 - 300)));
}

.verticle-align{
  text-align:center;
  display:flex;
  align-items:center;
  justify-content:center;
}

.no-style{
  padding:0;
  margin:0;
}

.confirm-green-box p {
  margin-bottom: 5px;
  margin-top: 5px;
}

</style>


@endsection
