@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        {{-- Breadcrumbs --}}
        <div class="col-12">
            <nav aria-label="bredcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index', $app->getLocale()) }}">{{ __('admin.Admin') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.news', $app->getLocale()) }}">{{ __('admin.News') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.News filters') }}</li>
                </ol>
            </nav>
        </div>
        {{--  --}}

        {{-- Errors --}}
        @if ($errors->any())
        <div class="col-12">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Status --}}
    @if (session('status'))
        <div class="col-12">
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        </div>
    @endif

        {{-- Filters --}}
        <div class="col-12">
            <h1>{{ __('admin.News filters') }}</h1>
        </div>

        @php
        $fCount = count($filters);
        @endphp

        @if($fCount == 0)
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    {{ __('admin.No filters') }}
                </div>
            </div>
        @endif

        @foreach ($filters as $filter)
            <div class="col-12">
                <div class="row g-2">
                    <div class="col"><h2 class="d-inline">{{ $filter->name }}</h2> - {{ $filter->lang }}</div> <div class="col-auto btn btn-link" style="padding-right:5px;" onclick="newsFilterEdit('news-filter-edit-modal', '{{ $filter->id }}', '{{ $filter->name }}', '{{ $filter->lang }}')"><i class="fa fa-pencil text-primary"></i></div> <div class="col-auto btn btn-link" style="padding-left: 5px;" onclick="newsFilterDelete('{{ __('admin.Delete filter and all filter words?') }}', '{{ route('admin.news.filters.delete',[app()->getLocale(), $filter->id]) }}');"><i class="fa fa-trash text-danger"></i></div>
                </div>
            </div>
            <div class="col-12">
                <small>{{ __('admin.Edit filter strings description') }}</small>
            </div>

            {{-- Textarea value --}}
            @php
                $words = '';
                foreach($filter->words as $word) {
                    $words .= $word->string . PHP_EOL;
                }
            @endphp
            {{-- --}}

            <div class="col-12">
                <form action="{{ route('admin.news.filters.words.store', [app()->getLocale()]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" name="words" id="words" rows="3" placeholder="{{ __('admin.Edit filter strings description') }}">{{ $words }}</textarea>
                    </div>
                    <input type="hidden" name="filter_id" value="{{ $filter->id }}">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ __('admin.Refresh') }}</button>
                    </div>
                </form>
            </div>
        @endforeach

        {{-- Add filter name --}}
        <div class="col-12">
            <form class="row g-3" action="{{ route('admin.news.filters.store', [app()->getLocale()]) }}" method="POST">
                @csrf
                <div class="col" style="padding-right: 0px;">
                    <input type="text" class="form-control" name="filter" id="filter" placeholder="{{ __('admin.Filter name') }}">
                </div>
                <div class="col-auto" style="padding-left:5px; padding-right:5px;">
                    <select class="form-control" name="lang" id="lang">
                        <option value="ru">RU</option>
                        <option value="lv">LV</option>
                    </select>
                </div>
                <div class="col-auto" style="padding-left:0px;">
                    <button type="submit" class="btn btn-primary">{{ __('admin.Add filter') }}</button>
                </div>
            </form>
        </div>

        {{-- --}}
    </div>
</div>

{{-- Edit filter modal --}}
@include('admin.include._newsFilterEdit')
{{--  --}}

@endsection