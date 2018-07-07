@component('profiles.activities.activity')
    @slot('heading')
    {{ $profileUser->name }} created a new channel <a href="/threads/{{$activity->subject->slug}}">{{ ($activity->subject->name)}}</a>
    @endslot

    @slot('body')
    {{$activity->subject->desc}}
    @endslot

@endcomponent
