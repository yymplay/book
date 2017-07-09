@extends('master')

@section('title','书籍类别')
@section('content')
<div class="weui_cells_title">选择书籍类别</div>
<div class="weui_cells weui_cells_split">
    <div class="weui_cell weui_cell_select">
        <div class="weui_cell_bd weui_cell_primary">
            <select class="weui_select" name="category">
                @foreach($categorys as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>

    </div>
</div>
<div class="weui_cells weui_cells_access">

</div>
@endsection

@section('my-js')
<script>
getCategory();
	$('.weui_select').on('change',function(){
		getCategory();
	});
	function getCategory(){
		//获取选中元素
		var parent_id = $('.weui_select option:selected').val();
		console.log(parent_id);
		$.ajax({
		      url:'/service/getcategory/parent_id/'+parent_id,
		      dataType:'json',
		      cache:false,
		      method:'post',
		      data:{_token:"{{csrf_token()}}"},
		      success:function(data){
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
		            $('.weui_cells_access').html('');
		            console.log(data);
		            console.log(data.childrens.length);
		            var node='';
		            for(var i=0;i<data.childrens.length;i++){
		            	node+='<a class="weui_cell" href="/product/category_id/'+data.childrens[i].id+'">'+
					        '<div class="weui_cell_bd weui_cell_primary">'+
					            '<p>'+data.childrens[i].name+'</p>'+
					        '</div>'+
					        '<div class="weui_cell_ft"></div>'+
					    '</a>'
		            }
		            $('.weui_cells_access').append(node);
		      },
		      error:function(xhr,status,error){
		      		console.log(xhr);
		      		console.log(status);
		      		console.log(error);
		      }
		});
	}
</script>
@endsection