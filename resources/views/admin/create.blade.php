@extends('admin.layouts.admin')
@section('title', 'Créer une FAQ')

@section('content')
    <div class="px-4 sm:px-6 py-6 sm:py-8 space-y-6">
        <div class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium">
            <a href="{{ route('admin.faq.index') }}"
               class="border border-input bg-background hover:bg-accent hover:text-accent-foreground flex items-center gap-2 h-9 rounded-md px-3">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        @include('faq::admin._form', [
          'categories' => $categories,
          'action' => route('admin.faq.store'),
          'method' => 'POST',
        ])
    </div>
@endsection
