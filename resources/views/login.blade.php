<!-- 继承master模板 -->
@extends('master')

@section('title','登录')

@section('content')
<h1>这是登录页面</h1>
@endsection
@include('component.loading')
@section('my-js')
<script>
	console.log('这是登录页面???');
</script>
@endsection