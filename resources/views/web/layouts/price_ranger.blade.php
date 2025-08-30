<div class="container">
    <div class="row slider-labels">
        <div class="col-9">
          <strong></strong> <span id="slider-range-value1"></span>
        </div>
        <div class="col-3">
          <strong></strong> <div id="slider-range-value2" style="float: right"></div>
        </div>
    </div><br>
    <div class="row">
      <div class="col-sm-12">
        <div id="slider-range"></div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-sm-12">
        <form>
          <input type="hidden" name="min-value" id="price-min-value" value="{{@$min_price??10}}">
          <input type="hidden" name="max-value" id="price-max-value" value="{{@$max_price??100000}}">
        </form>
      </div>
    </div>
</div>

<style>
    .slider-labels {
    margin-top: 10px;
    }

    .noUi-target,.noUi-target * {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -ms-touch-action: none;
    touch-action: none;
    -ms-user-select: none;
    -moz-user-select: none;
    user-select: none;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    }

    .noUi-target {
    position: relative;
    direction: ltr;
    }

    .noUi-base {
    width: 100%;
    height: 100%;
    position: relative;
    z-index: 1;
    /* Fix 401 */
    }

    .noUi-origin {
    position: absolute;
    right: 0;
    top: 0;
    left: 0;
    bottom: 0;
    }

    .noUi-handle {
    position: relative;
    z-index: 1;
    }

    .noUi-stacking .noUi-handle {
    /* This class is applied to the lower origin when
    its values is > 50%. */
    z-index: 10;
    }

    .noUi-state-tap .noUi-origin {
    -webkit-transition: left 0.3s,top .3s;
    transition: left 0.3s,top .3s;
    }

    .noUi-state-drag * {
    cursor: inherit !important;
    }

    /* Painting and performance;
    * Browsers can paint handles in their own layer.
    */
    .noUi-base,.noUi-handle {
    -webkit-transform: translate3d(0,0,0);
    transform: translate3d(0,0,0);
    }

    /* Slider size and handle placement;
    */
    .noUi-horizontal {
    height: 4px;
    }

    .noUi-horizontal .noUi-handle {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    left: -7px;
    top: -7px;
    background-color: #345DBB;
    }

    /* Styling;
    */
    .noUi-background {
    background: #D6D7D9;
    }

    .noUi-connect {
    background: #345DBB;
    -webkit-transition: background 450ms;
    transition: background 450ms;
    }

    .noUi-origin {
    border-radius: 2px;
    }

    .noUi-target {
    border-radius: 2px;
    }

    .noUi-target.noUi-connect {
    }

    /* Handles and cursors;
    */
    .noUi-draggable {
    cursor: w-resize;
    }

    .noUi-vertical .noUi-draggable {
    cursor: n-resize;
    }

    .noUi-handle {
    cursor: default;
    -webkit-box-sizing: content-box !important;
    -moz-box-sizing: content-box !important;
    box-sizing: content-box !important;
    }

    .noUi-handle:active {
    border: 8px solid #345DBB;
    border: 8px solid rgba(53,93,187,0.38);
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    left: -14px;
    top: -14px;
    }

    /* Disabled state;
    */
    [disabled].noUi-connect,[disabled] .noUi-connect {
    background: #B8B8B8;
    }

    [disabled].noUi-origin,[disabled] .noUi-handle {
    cursor: not-allowed;
    }
</style>