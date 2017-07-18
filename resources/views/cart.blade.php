@extends('master')

@section('title', '购物车')

@section('content')
@if($cart_items!=null)
  <div class="page bk_content" style="top: 0;">
    <div class="weui_cells weui_cells_checkbox">
        @foreach($cart_items as $cart_item)
        <label class="weui_cell weui_check_label" for="{{$cart_item->product->id}}">
            <div class="weui_cell_hd" style="width: 23px;">
                <input type="checkbox" class="weui_check" name="cart_item" id="{{$cart_item->product->id}}" checked="checked">
                <i class="weui_icon_checked"></i>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
              <div style="position: relative;">
                <img class="bk_preview" src="{{$cart_item->product->preview}}" class="m3_preview" onclick="_toProduct({{$cart_item->product->id}});"/>
                <div style="position: absolute; left: 100px; right: 0; top: 0">
                  <p>{{$cart_item->product->name}}</p>
                  <p class="bk_time" style="margin-top: 15px;">数量: <span class="bk_summary">x{{$cart_item->count}}</span></p>
                  <p class="bk_time">总计: <span class="bk_price">￥{{$cart_item->product->price * $cart_item->count}}</span></p>
                </div>
              </div>
            </div>
        </label>
        @endforeach
    </div>
  </div>
  {{-- <form action="/order_commit" id="order_commit" method="post">
    {{ csrf_field() }}
    <input type="hide" name="product_ids" value="" />
    <input type="hide" name="is_wx" value="" />
  </form> --}}
  <div class="bk_fix_bottom">
    <div class="bk_half_area">
      <button class="weui_btn weui_btn_primary" onclick="_toCharge();">结算</button>
    </div>
    <div class="bk_half_area">
      <button class="weui_btn weui_btn_default" onclick="javascript:$('.weui_dialog_confirm').show();">删除</button>
    </div>
  </div>
<div class="weui_dialog_confirm" style="display:none;">
    <div class="weui_mask"></div>
    <div class="weui_dialog">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">确定删除吗?</strong></div>
        <div class="weui_dialog_bd"><br></div>
        <div class="weui_dialog_ft">
            <a href="javascript:$('.weui_dialog_confirm').hide();" class="weui_btn_dialog default">取消</a>
            <a href="javascript:javascript:$('.weui_dialog_confirm').hide();_onDelete();" class="weui_btn_dialog primary">确定</a>
        </div>
    </div>
</div>
@else
<div class="weui_msg">
    <div class="weui_icon_area"><i class="weui_icon_waiting weui_icon_msg"></i></div>
    <div class="weui_text_area"> 
        <p class="weui_msg_desc">还没有商品哦,赶快去添加吧!</p>
    </div>
    <div class="weui_opr_area">
        <p class="weui_btn_area">
            <a href="/" class="weui_btn weui_btn_primary">好的</a>
        </p>
    </div>
</div>
@endif
@endsection

@section('my-js')
<script type="text/javascript">
$('input:checkbox[name=cart_item]').click(function(event){
    if($(this).attr('checked')=='checked'){
        $(this).attr('checked',false);
        $(this).next().removeClass('weui_icon_checked');
        $(this).next().addClass('weui_icon_unchecked');
    }else{
        $(this).attr('checked','checked');
        $(this).next().removeClass('weui_icon_unchecked');
        $(this).next().addClass('weui_icon_checked');
        
    }
});
  function _onDelete() {
      var product_id=[];
      $('input:checkbox[name=cart_item]').each(function(index,el) {
          if($(this).attr('checked')=='checked'){
              product_id.push($(this).attr('id'));
          }
          
      });
      console.log(product_id+'');
      if(product_id.length==0){
          $('.bk_toptips').show();
          $('.bk_toptips span').html('请选择删除项');
          setTimeout(function() {$('.bk_toptips').hide();}, 2000);
          return;
      }
      $.ajax({
          url:'/service/cart/del',
          dataType:'json',
          cache:false,
          method:'post',
          data:{_token:"{{csrf_token()}}",productids:product_id},
          success:function(data){
                console.log(data);
                if(data == null) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('服务端错误');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }
                if(data.status!=0){
                  $('.bk_toptips').show();
                  $('.bk_toptips span').html(data.message);
                  setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                  return;
                }
                $('.bk_toptips').show();
                $('.bk_toptips span').html(data.message);
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                setTimeout(function() {location.reload();}, 2000);
          },
          error:function(xhr,status,error){
              console.log(xhr);
              console.log(status);
              console.log(error);
          }
    });
  }
  function _toProduct(){

  }
  function _toCharge(){
      //获取选中的\
      var product_id=[];
      $('input[name=cart_item]:checkbox').each(function(){
          if($(this).attr('checked')=='checked'){
              product_id.push($(this).attr('id'));
          }
             
      })
      console.log(product_id);
      if(product_id.length==0){
            $('.bk_toptips').show();
            $('.bk_toptips span').html('请先选择');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return;
      }
      location.href="/paypage/"+product_id;
  }
</script>
@endsection
