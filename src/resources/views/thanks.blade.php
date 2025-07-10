@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}" />

<style>
    .form__button-submit {
        display: inline-block;
        padding: 12px 24px;
        background-color: #333;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        text-align: center;
    }
</style>

@endsection

@section('content')
<div class="thanks__content">
    <div class="thanks__heading">
        <h2>お問い合わせありがとうございます</h2>
    </div>
    <div class="form__button">
        <a href="/" class="form__button-submit">HOME</a>
    </div>
</div>
@endsection