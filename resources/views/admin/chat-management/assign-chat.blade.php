@extends('admin.layouts.app')

@section('content')
<div class="col-lg-12 p-0">
    <div class="card">
        <div class="card-body">

            <form action="{{ route('chats.assign.store', $chat->uuid) }}" method="post" enctype="multipart/form-data" data-parsley-validate>
                @csrf

                <div class="row">
                    <div class="form-group col-md-6 p-2">
                        <label>{{ __('Assign Agent') }} <span class="error">*</span></label>
                        <select name="agent_id" class="form-control" required>
                            <option value="">{{ __('Select Agent') }}</option>
                            @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ $chat->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->first_name }}</option>
                            @endforeach
                        </select>

                        @error('agent_id')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>





                </div>

                <div class="form-group mt-4">
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-success waves-effect waves-lightml-2" type="submit">
                            <i class="fa fa-save"></i> {{ __('Submit') }}
                        </button>
                        <a class="btn btn-danger waves-effect" href="{{ route('auto-reply-rules.index') }}">
                            <i class="fa fa-times"></i> {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> <!-- end col -->
@endsection

@push('style')
@endpush
@push('script')
@endpush
