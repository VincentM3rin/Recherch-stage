@extends('layouts.app')

@section('content')
    <h1>Contactez-nous</h1>

    @if(session('success'))
        <x-alerte type="success">
            {{ session('success') }}
        </x-alerte>
    @endif

    <form action="{{ route('contact.send') }}" method="POST" style="max-width: 500px;">
        @csrf
        <x-input name="nom" label="Votre nom" />
        <x-input name="email" label="Votre e-mail" type="email" />
        
        <div style="margin-bottom: 15px;">
            <label for="message" style="display: block; font-weight: bold; margin-bottom: 5px;">Message</label>
            <textarea name="message" id="message" rows="5" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"></textarea>
        </div>

        <button type="submit" style="padding: 10px 15px; background: #333; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Envoyer
        </button>
    </form>
@endsection