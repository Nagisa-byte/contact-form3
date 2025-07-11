@extends('layouts.app')

@section('header-button')
<a href="/login" class="header__login-button">login</a>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}" />
@endsection


@section('content')
<div class="confirm__content">
    <div class="confirm__heading">
        <h2>Confirm</h2>
    </div>
    <form class="form" action="/contacts/store" method="post">
        @csrf
        <div class="confirm-table">
            <table class="confirm-table__inner">
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お名前</th>
                    <td class="confirm-table__text">
                        <input type="text" name="name" value="{{ $contact['last_name'] . $contact['first_name'] }}" readonly />
                    </td>
                </tr>

                @php
                $genders = [1 => '男性', 2 => '女性', 3 => 'その他'];
                @endphp

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">性別</th>
                    <td class="confirm-table__text">
                        <input type="text" name="gender" value="{{ $genders[$contact['gender']] ?? '不明' }}" readonly />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">メールアドレス</th>
                    <td class="confirm-table__text">
                        <input type="email" name="email" value="{{$contact['email']}}" readonly />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">電話番号</th>
                    <td class="confirm-table__text">
                        <input type="tel" name="tel" value="{{$contact['tel']}}" readonly />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">住所</th>
                    <td class="confirm-table__text">
                        <input type="text" name="address" value="{{$contact['address']}}" readonly />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">建物名</th>
                    <td class="confirm-table__text">
                        <input type="text" name="building" value="{{$contact['building']}}" readonly />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせの種類</th>
                    <td class="confirm-table__text">
                        <input type="text" name="category_id" value="{{ $contact['content'] }}">
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせ内容</th>
                    <td class="confirm-table__text">
                        <input type="text" name="detail" value="{!! nl2br(e($contact['detail'])) !!}">
                    </td>
                </tr>

            </table>
        </div>
        <div class="form__button">
            <button class="form__button-submit" name="action" type="submit" value="submit">送信</button>
        </div>
    </form>
    <form action="/contacts/back" method="post">
        @csrf
        <input type="hidden" name="action" value="back">
        {{-- 以下に全ての項目の hidden フィールドを入れて戻す --}}
        <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
        <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
        <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
        <input type="hidden" name="email" value="{{ $contact['email'] }}">
        {{-- tel は分割して渡す --}}
        @php
        $telParts = explode('-', $contact['tel']);
        @endphp
        <input type="hidden" name="tel[]" value="{{ $telParts[0] }}">
        <input type="hidden" name="tel[]" value="{{ $telParts[1] }}">
        <input type="hidden" name="tel[]" value="{{ $telParts[2] }}">
        <input type="hidden" name="address" value="{{ $contact['address'] }}">
        <input type="hidden" name="building" value="{{ $contact['building'] }}">
        <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
        <input type="hidden" name="detail" value="{{ $contact['detail'] }}">

        <div class="form__button">
            <button class="form__button-back" name="action" type="submit" value="back">修正</button>
        </div>
    </form>

</div>
@endsection