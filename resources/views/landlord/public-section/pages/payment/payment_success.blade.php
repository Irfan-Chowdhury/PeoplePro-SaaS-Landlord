@extends('landlord.public-section.layouts.master')
@section('public-title', config('app.name').' | '.'Payment Success')

@section('public-content')

@push('css')
    <style>
        .payment{
            border:1px solid #f2f2f2;
            border-radius:3px;
            background:#e5e8ec;
            padding-bottom:30px;
        }
        .payment_header{
            background:#03a969;
            padding:15px;
            border-radius:3px 3px 0 0
        }
        .check{
            margin:0 auto;
            width:50px;
            height:50px;
            border-radius:100%;
            background:#fff;
            text-align:center
        }
        .check i{
            vertical-align:middle;
            line-height:50px;
            font-size:30px
        }
        .content{
            text-align:center
        }
        .content h1{
            font-size:25px;
            padding-top:25px
        }
        .buttonBackgroud {
            background: #03a969
        }
    </style>
@endpush


<section>
    <div class="container">
        <div class="row">
        <div class="col-md-6 mx-auto mt-5">
            <div class="payment mb-5">
                <div class="payment_header">
                    <div class="check"><i class="las la-check"></i></div>
                </div>
                <div class="content">
                    <h1>@lang('file.Successfully Done')!</h1>
                    {{-- <p class="mb-3">@lang("file.Your order has been confirmed. You'll receive an order confirmation email shortly").</p> --}}
                    <a class="button buttonBackgroud text-light" href="http://{{ $domain }}">@lang('file.Please visit your App')</a>
                </div>

            </div>
        </div>
        </div>
    </div>
</section>

@endsection

