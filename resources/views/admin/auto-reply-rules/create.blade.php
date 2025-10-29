@extends('admin.layouts.app')

@section('content')
<div class="col-lg-12 p-0">
    <div class="card">
        <div class="card-body">

            <form action="{{ route('auto-reply-rules.store') }}" method="post" enctype="multipart/form-data" data-parsley-validate>
                @csrf

                <input type="hidden" name='status' value="{{STATUS_ACTIVE}}">
                <div class="row">
                    <div class="form-group col-md-6 p-2">
                        <label>{{ __('Keyword') }} <span class="error">*</span></label>
                        <input type="text" name="keyword" class="form-control" placeholder="Enter Keyword" required
                            value="{{ old('keyword') }}">

                        @error('keyword')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 p-2">
                        <label>{{ __('Priority') }} <span class="error">*</span></label>
                        <input type="number" value="{{ old('priority') }}" name="priority"
                            class="form-control" required>

                        @error('priority')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-12 p-2">
                        <label>{{ __('Reply') }} <span class="error">*</span></label>
                        <textarea name="reply" class="form-control" required placeholder="Enter Reply" rows="4">{{ old('reply') }}</textarea>

                        @error('reply')
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
