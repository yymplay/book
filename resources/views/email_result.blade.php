@extends('master')

@section('title','邮箱验证')
@section('content')
<div class="weui_msg">
    <div class="weui_icon_area"><i class="{{$info['icon']}} weui_icon_msg"></i></div>
    <div class="weui_text_area">
        <h2 class="weui_msg_title">{{$info['msg']}}</h2>
        <p class="weui_msg_desc">内容详情，可根据实际需要安排</p>
    </div>
    <div class="weui_opr_area">
        <p class="weui_btn_area">
            <a href="javascript:;" class="weui_btn weui_btn_primary">立即登录</a>
            <a href="javascript:;" class="weui_btn weui_btn_default">返回首页</a>
        </p>
    </div>
    <div class="weui_extra_area">
        <a href="">查看详情</a>
    </div>
</div>
@endsection

@section('my-js')
@endsection
