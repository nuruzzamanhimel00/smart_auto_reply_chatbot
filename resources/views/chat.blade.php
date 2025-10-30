@extends('layout.app')

@section('content')
<div id="vueApp">
    <guest-chat-box :chat="{{ json_encode($chat) }}"></guest-chat-box>
</div>
@endsection

@push('style')

@endpush

@push('script')
    <script>
        // Auto-refresh table every 30 seconds (optional)
        // setInterval(function() {
        //     location.reload();
        // }, 30000);
    </script>
@endpush
