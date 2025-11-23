@extends('layouts.rpg-layout')

@section('title', 'Zbrojmistrz')

@section('content')
    <div class="rpgui-container framed-golden-2" style="padding:30px; max-width:800px; margin:auto;">
        <h2 class="section-title" style="text-align:center;">⚔️ Zbrojmistrz</h2>
        <p style="text-align:center;">Tutaj możesz kupić lub ulepszyć zbroje dla swojej postaci.</p>
        <p style="text-align:center;">(Placeholder – wkrótce zostanie rozwinięty)</p>
        <div class="rpgui-center" style="margin-top:20px;">
            <a href="{{ route('city') }}" class="rpgui-button">← Powrót do miasta</a>
        </div>
    </div>
@endsection
