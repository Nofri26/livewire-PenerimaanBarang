@extends('layouts.index')

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                @livewire('user-login')
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
@endsection