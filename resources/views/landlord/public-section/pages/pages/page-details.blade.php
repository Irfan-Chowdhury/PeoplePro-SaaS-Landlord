@php
    $generalSetting = DB::table('general_settings')
        ->latest()
        ->first();
@endphp


@extends('landlord.public-section.layouts.master')
@section('public-content')
    <section id="blog">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 text-center mb-5">
                    <h1 class="mt-3 text-center">{{$page->title}}</h1>
                </div>
                <div class="col-md-6 offset-md-3 mb-5">
                    {!! $page->description !!}
                </div>
            </div>
        </div>
    </section>
@endsection
