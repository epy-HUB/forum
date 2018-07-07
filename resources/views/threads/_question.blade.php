<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="form-group">
            <input class="form-control" type="text" v-model="form.title">
        </div>
    </div>
    
    <div class="panel-body">
        <div class="form-group">
            <textarea class="form-control"
             name="" 
             id="" 
             cols="30" 
             rows="10" 
             v-model="form.body"></textarea>
        </div>
    </div>
    <div v-if="authorize('owns', thread) || authorize('isAdmin')">
        <div class="panel-footer" >
            <div class="level">
            <button class="btn btn-xs" @click="editing=true" v-show="!editing">Edit</button>
            <button class="btn btn-primary btn-xs mr-1" @click="update" v-show="editing">Update</button>
            <button class="btn btn-xs" @click="resetForm">Cancel</button>
                @can('update', $thread)
                    <form action="{{ $thread->path() }}" method="POST" class="ml-a">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-link">Delete Thread</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>

</div>



<div class="panel panel-default"  v-else>
    <div class="panel-heading">
        <div class="level">
            <img src="{{ asset( $thread->creator->avatar_path) }}" alt="avatar" width="25" height="25">
            <span class="flex">
                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> 
                <span v-text="title"></span>
            </span>
        </div>
    </div>

    <div class="panel-body" v-text="body">
    
    </div>
    <div v-if="authorize('owns', thread) || authorize('isAdmin')">
    <div class="panel-footer">
        <button class="btn btn-xs" @click="editing = true">Edit</button>
    </div>
    </div>
</div>


