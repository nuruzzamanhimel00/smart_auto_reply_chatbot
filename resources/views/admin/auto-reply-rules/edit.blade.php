@extends('admin.layouts.app')
@section('content')
    <div class="col-lg-12 p-0">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('auto-reply-rules.update', $data->id) }}" method="post" enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    @method('PUT')

                    <div class="row">
                    <div class="form-group col-md-6 p-2">
                        <label>{{ __('Keyword') }} <span class="error">*</span></label>
                        <input type="text" name="keyword" class="form-control" placeholder="Enter Keyword" required
                            value="{{ old('keyword',$data->keyword) }}">

                        @error('keyword')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 p-2">
                        <label>{{ __('Priority') }} <span class="error">*</span></label>
                        <input type="number" value="{{ old('priority',$data->priority) }}" name="priority"
                            class="form-control" required>

                        @error('priority')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-12 p-2">
                        <label>{{ __('Reply') }} <span class="error">*</span></label>
                        <textarea name="reply" class="form-control" required placeholder="Enter Reply" rows="4">{{ old('reply',$data->reply) }}</textarea>

                        @error('reply')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-xl-4 col-lg-6 p-2 ">
                            <div class="row">
                                <label class="d-block mb-3 col-md-12">{{ __('Status') }} <span class="error">*</span></label>
                                <div class="custom-control custom-radio custom-control-inline col-md-4">
                                    <input type="radio" id="status_yes" value="{{ \App\Models\User::STATUS_ACTIVE }}"
                                           name="status" class="custom-control-input" {{ old('status',$data->status) == \App\Models\User::STATUS_ACTIVE ? 'checked=""' : '' }}>
                                    <label class="custom-control-label" for="status_yes">{{ __('Active') }}</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline col-md-4">
                                    <input type="radio" id="status_no" value="{{ \App\Models\User::STATUS_INACTIVE }}"
                                           name="status" class="custom-control-input" {{ old('status',$data->status) == \App\Models\User::STATUS_INACTIVE ? 'checked=""' : '' }}>
                                    <label class="custom-control-label" for="status_no">{{ __('Inactive') }}</label>
                                </div>
                            </div>

                            @error('status')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>


                </div>

                    <div class="form-group">
                        <div>
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
