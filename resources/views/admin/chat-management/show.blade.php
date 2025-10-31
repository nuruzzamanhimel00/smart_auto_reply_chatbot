@extends('admin.layouts.app')

@section('content')
<div id="vueApp">
    <admin-chat-box :chat="{{ json_encode($chat) }}"></admin-chat-box>
</div>
@endsection

@push('style')
@endpush
@push('script')
@endpush
