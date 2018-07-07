@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new Thread</div>

                <div class="panel-body">
                  <form method="POST" action="/threads">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="channerl_id">Choose a channel</label>
                        <select name="channel_id" id="channel_id" class="form-control" required>
                            <option value="">Choose one...</option>
                            @foreach(App\Channel::all() as $channel)
                                <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input name="title" type="text" class="form-control" id="title" value="{{ old('title') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea name="body" type="text" class="form-control" id="body" rows="8" value="{{ old('title') }}" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Publish</button>
                    </div>
                      @if(count($errors))
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


