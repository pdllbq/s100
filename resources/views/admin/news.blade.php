@extends('layouts.app')

@section('title', __('admin.Admin News'))

@section('content')
    
    <div class="container">
        <div class="row">
            {{-- Breadcrumb --}}
            <div class="col-12">
                <nav aria-label="bredcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index', $app->getLocale()) }}">{{ __('admin.Admin') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('admin.News') }}</li>
                    </ol>
                </nav>
            </div>
            {{-- --}}

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
                <a href="{{ route('admin.news.filters',[app()->getLocale()]) }}">{{ __('admin.Configure filters') }}</a>
            </div>

            {{-- Sources --}}
            <div class="col-12">
                <h2>{{ __('admin.News sources') }}</h2>
            </div>

            {{-- Sorces list --}}
            @php
                $count = count($sources);
            @endphp
            @if ($count == 0)
                <div class="col-12">
                    <div class="alert alert-warning">
                        {{ __('admin.No sources') }}
                    </div>
                </div>
            @else

            <div class="col"><hr></div>
            @endif
            
            @foreach ($sources as $data)
                <div class="col-12">
                    <div class="row g-4">
                        <div class="col">{{ $data->url }}</div>
                        <div class="col-auto">{{ $data->lang }}</div>
                        <div 
                            class="col-auto btn btn-link"
                            style="padding-right:5px;" 
                            onclick="newsSourceEdit('news-source-edit-modal', '{{ $data->lang }}', '{{ $data->id}}', '{{ $data->url }}', '{{ $data->lang }}');"
                        >
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </div>
                        <div 
                            class="col-auto btn btn-link text-danger" 
                            style="padding-left:5px;"
                            onclick="newsSourceDelete('{{ __('admin.Delete source?') }}', '{{ route('admin.news.delete', [app()->getLocale(), $data->id]) }}');"    
                        >
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="col"><hr></div>
            @endforeach

            {{-- Add --}}
            <div class="col-12">
                <form class="row g-3" action="{{ route('admin.news.store',[app()->getLocale()]) }}" method="post">
                    @csrf
                    <div class="col" style="padding-right: 0px;">
                        <input type="text" class="form-control" name="add_source_url" id="add_source_url" placeholder="{{ __('admin.Source url') }}">
                    </div>
                    <div class="col-auto" style="padding-left: 5px; padding-right:5px;">
                        <select class="form-control" name="add_source_lang" id="add_source_lang">
                            <option value="ru">RU</option>
                            <option value="lv">LV</option>
                        </select>
                    </div>
                    <div class="col-auto" style="padding-left: 0px;">
                        <button type="submit" class="btn btn-primary">{{ __('admin.Add source') }}</button>
                    </div>
                </form>
            </div>
            {{-- --}}

        </div>
    </div>

    {{-- Edit source html part --}}
    @include('admin.include._newsEditSource')
    {{-- --}}

@endsection