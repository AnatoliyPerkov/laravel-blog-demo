@extends('layouts.app')

@section('content')

    <form method="POST" action="?">
        @csrf
        <div class="form-floating">
            <label for="reason" class="col-form-label">Reason</label>
            <textarea class="form-control{{ $errors->has('reason') ? ' is-invalid' : '' }}" placeholder="Leave a comment here" id="reason" name="reason" required>
                {{ old('reason', $post->reject_reason) }}
            </textarea>
            @if ($errors->has('reason'))
                <span class="invalid-feedback"><strong>{{ $errors->first('reason') }}</strong></span>
            @endif
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary mt-2">Reject</button>
        </div>
    </form>

@endsection
