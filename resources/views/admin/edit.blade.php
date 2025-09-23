@extends('admin.layouts.admin')

@section('title', 'Modifier la faq : ', $item->name)

@section('content')
    <div class="px-6 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">Crée une FAQ</h1>
        </div>

        @include('faq::admin._form', [
    'item' => $item,
    'categories'=> $categories,
    'action' => route('admin.faq.update', $item),
    'method' => 'PUT',
])

    </div>
@endsection
