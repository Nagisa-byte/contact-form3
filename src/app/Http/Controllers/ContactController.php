<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $tel = implode('-', $request->input('tel'));

        $contact = $request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'category_id',
            'detail',
        ]);
        $contact['tel'] = $tel;
        $category = Category::find($contact['category_id']);
        $contact['content'] = $category ? $category->content : '不明';

        if ($request->input('action') === 'back') {
            return redirect('/contacts')->withInput();
        }


        return view('confirm', ['contact' => $contact]);
    }


    public function store(ContactRequest $request)
    {

        $tel = implode('-', $request->input('tel'));

        $contact = $request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'address',
            'building',
            'category_id',
            'detail'
        ]);
        $contact['tel'] = $tel;


            Contact::create($contact);
            return view('/thanks');
    }

    public function back(ContactRequest $request){
        return redirect('/contacts')->withInput();
    }

    public function list(Request $request)
    {
        // お問い合わせ一覧のベースクエリ
        $query = Contact::query();

        // キーワード検索（名前・メール・お問い合わせ内容）
        if ($keyword = $request->input('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('detail', 'like', "%{$keyword}%"); // お問い合わせ本文に対して
            });
        }

        // 性別検索（1: 男性, 2: 女性, 3: その他）
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // お問い合わせの種類（カテゴリID）
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // 日付（1日単位で検索）
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        // 並び順＆ページネーション（例: 7件ずつ）
        $contacts = $query->latest()->paginate(7)->appends($request->query());

        // カテゴリ情報をビューに渡す（id => content形式）
        $categories = Category::pluck('content', 'id')->toArray();

        return view('admin', compact('contacts', 'categories'));
    }
}
