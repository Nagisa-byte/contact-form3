@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header-button')
<form action="/login" method="get" class="header__logout-form">
    <button type="submit" class="header__logout-button">logout</button>
</form>
@endsection
@section('content')
<div class="contact__content">
    <div class="section__title">
        <h2>Admin</h2>
    </div>

    {{-- 検索フォーム --}}
    <form method="GET" action="/admin" class="search-form">
        <div class="search-form__filters">
            <div class="search-form__item">
                <input class="search-form__item-input" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">
            </div>
            <div class="search-form__item">
                <select name="gender" class="search-form__item-select">
                    <option value="">性別</option>
                    <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                    <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                    <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                </select>
            </div>
            <div class="search-form__item">
                <select name="category_id" class="search-form__item-select">
                    <option value="">お問い合わせの種類</option>
                    @foreach ($categories as $id => $label)
                    <option value="{{ $id }}" {{ request('category_id') == $id ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="search-form__item">
                <input type="date" name="date" class="search-form__item-input" value="{{ request('date') }}">
            </div>
            <div class="search-form__button">
                <button class="search-form__button-submit" type="submit">検索</button>
                <a href="/admin" class="search-form__button-reset">リセット</a>
            </div>
        </div>
    </form>

    {{-- ページネーション --}}
    <div style="margin-top: 1em;">
        {{ $contacts->links() }}
    </div>

    {{-- 一覧テーブル --}}
    <div class="contact-table">
        <table class="contact-table__inner">
            <thead class="contact-table__row">
                <tr class="contact-table__header">
                    <th>名前</th>
                    <th>性別</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせの種類</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="contact-table__row">
                @forelse ($contacts as $contact)
                <tr class="contact-table__item">
                    <td>{{ $contact->last_name . ' ' . $contact->first_name }}</td>
                    @php
                    $genders = [1 => '男性', 2 => '女性', 3 => 'その他'];
                    @endphp
                    <td>{{ $genders[$contact->gender] ?? '不明' }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $categories[$contact->category_id] ?? '未分類' }}</td>
                    <td><button type="button" class="detail-button" data-contact='@json($contact)'>詳細</button></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">お問い合わせが見つかりませんでした。</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- モーダル -->
    <div id="contactModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h3>お問い合わせ詳細</h3>
            <p><strong>お名前：</strong> <span id="modal-name"></span></p>
            <p><strong>性別：</strong> <span id="modal-gender"></span></p>
            <p><strong>メールアドレス：</strong> <span id="modal-email"></span></p>
            <p><strong>電話番号：</strong> <span id="modal-tel"></span></p>
            <p><strong>住所：</strong> <span id="modal-address"></span></p>
            <p><strong>建物名：</strong> <span id="modal-building"></span></p>
            <p><strong>お問い合わせの種類：</strong> <span id="modal-category"></span></p>
            <p><strong>お問い合わせ内容：</strong> <span id="modal-detail"></span></p>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('contactModal');
        const closeBtn = document.querySelector('.modal-close');

        document.querySelectorAll('.detail-button').forEach(btn => {
            btn.addEventListener('click', () => {
                const contact = JSON.parse(btn.dataset.contact);
                const genders = {
                    1: '男性',
                    2: '女性',
                    3: 'その他'
                };
                const categories = @json($categories);

                document.getElementById('modal-name').textContent = contact.last_name + ' ' + contact.first_name;
                document.getElementById('modal-gender').textContent = genders[contact.gender] || '不明';
                document.getElementById('modal-email').textContent = contact.email;
                document.getElementById('modal-tel').textContent = contact.tel;
                document.getElementById('modal-address').textContent = contact.address;
                document.getElementById('modal-building').textContent = contact.building;
                document.getElementById('modal-category').textContent = categories[contact.category_id] || '未分類';
                document.getElementById('modal-detail').textContent = contact.detail;

                modal.style.display = 'block';
            });
        });

        closeBtn.addEventListener('click', () => modal.style.display = 'none');
        window.addEventListener('click', e => {
            if (e.target === modal) modal.style.display = 'none';
        });
    });
</script>
@endsection