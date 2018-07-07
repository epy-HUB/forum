@extends('layouts.app')

@section('content')
<thread-view :thread="{{ $thread }}"  inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8" v-cloak>
                @include('threads._question')

                <replies  
                        @remove="repliesCount--" 
                        @added="repliesCount++"></replies>

            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <!-- <div class="panel-heading"> <a href="#">{{ $thread->creator->name }}</a> posted {{ $thread->title }}</div> -->

                    <div class="panel-body">
                        <p>
                            This thread was publised {{ $thread->created_at->diffForHumans() }}
                            by <a href="{{ route('profile', $thread->creator) }}"> {{ $thread->creator->name }} </a>
                            and currently has <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}
                        </p>
                        <p>
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                            
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</thread-view>

@endsection
