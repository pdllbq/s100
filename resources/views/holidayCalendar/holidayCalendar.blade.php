@extends('layouts.app')

@section('title', __('holidayCalendar.title', ['year' => $year]))

@if($year == 2024)
    @section('description', __('holidayCalendar.description2024'))
@else
    @section('description', __('holidayCalendar.description', ['year' => $year]))
@endif

@if($year == 2024)
    @section('keywords', __('holidayCalendar.keywords2024'))
@else
    @section('keywords', __('holidayCalendar.keywords', ['year' => $year]))
@endif

@section('content')



<div class="container">
    <div class="row">

        <div class="col-12">
            <h1 class="text-center">{{ __('holidayCalendar.title', ['year' => null]) }}</h1>
        </div>

        <div class="col-12 h1 text-center">
            {{ __('holidayCalendar.year') }}: 
            <a href="{{ route('holidayCalendar',[$lang,'2023']) }}" class="@if($year == 2023) disabled @endif">2023</a> 
            / 
            <a href="{{ route('holidayCalendar',[$lang,'2024']) }}" class="@if($year == 2024) disabled @endif">2024</a>
        </div>

        <div class="col-12">
            @if($year != 2024)
                {{ __('holidayCalendar.Description', ['year' => $year]) }}
            @endif
        </div>
        
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarJan !!}
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarFeb !!}
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarMar !!}
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarApr !!}
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarMay !!}
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarJun !!}
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarJul !!}
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarAug !!}
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarSep !!}
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarOct !!}
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarNov !!}
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            {!! $calendarDec !!}
        </div>

        @if($year == 2024)
            <div class="col-12">
                @include('holidayCalendar.description.'.app()->getLocale())
            </div>
        @endif

        <div class="col-12">
            @include('include.ads.ads')
        </div>

    </div>
</div>

@endsection