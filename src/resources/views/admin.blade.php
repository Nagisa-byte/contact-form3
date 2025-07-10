@section('content')
<div class="contact__content">
    <div class="section__title">
        <h2>お問い合わせ一覧</h2>
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
                    <th><a>詳細</a></th>
                </tr>
            </thead>
            <tbody class="contact-table__row">
                @forelse ($contacts as $contact)
                <tr class="contact-table__item">
                    <td>{{ $contact->name }}</td>
                    @php
                    $genders = [1 => '男性', 2 => '女性', 3 => 'その他'];
                    @endphp
                    <td>{{ $genders[$contact->gender] ?? '不明' }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $categories[$contact->category_id] ?? '未分類' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">お問い合わせが見つかりませんでした。</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection