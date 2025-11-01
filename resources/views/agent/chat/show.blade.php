@extends('admin.layouts.app')

@section('content')
<div id="vueApp">
    <agent-chat-box :chat="{{ json_encode($chat) }}"></agent-chat-box>
</div>
@endsection

@push('style')
@endpush
@push('script')
@endpush
