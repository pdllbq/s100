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

            {{-- Sorces list --}}

            {{-- --}}

        </div>
    </div>

@endsection