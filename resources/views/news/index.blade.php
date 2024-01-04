@extends('layouts.app')

@section('title',$title)

@if(isset($description))
	@section('description',$description)
@endif

@php
	if(!isset($activeFilter)){
		$activeFilter = null;
	}
@endphp

@section('content')

<div class="container-fluid">
	<div class="row">

		<div class="col-12">
			@include('news.parts._filtersList',compact('filters','activeFilter'))
		</div>
		
		@include('news.parts._newsList', compact('newsList'))

	</div>
</div>

@endsection