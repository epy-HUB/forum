<template>
    <div>
        <h1>Add Channel</h1>
        <form action="#" @submit.prevent="edit ? updateChannel(channel.id) : createChannel()">
            <div class="form-group">
                <label for="name">Name</label>
                <input v-model="channel.name" type="text" name="name" class="form-control"> 
            </div>
            <div class="form-group">
                <label for="desc">Description</label>
                <input v-model="channel.desc" type="text" name="desc" class="form-control"> 
            </div>
            <div class="form-group">
                <button v-show="!edit" type="submit" class="btn btn-primary">New Channel</button>
                <button v-show="edit" type="submit" class="btn btn-primary">Update Channel</button>
            </div>
        </form>

        <h1>Channels</h1>
        <ul class="list-group">
            <li v-for="channel in list" class="list-group-item">
                {{ channel.name }}
                <button @click="showChannel(channel.id)" class="btn btn-default btn-xs">Edit</button>
                <button @click="deleteChannel(channel.id)" class="btn btn-danger btn-xs">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
    export default{
        props: ['channels'],
        data: function(){
            return {
                edit: false,
                list: this.channels,
                channel: {
                    id: '',
                    name: '',
                    desc: ''
                }
            };
        },

        mounted: function(){
            console.log('channel component loaded');
            this.fetchChannelList();
        },

        methods: {
            fetchChannelList: function(){
                console.log('fetching  contacts');
                let self = this;
                axios.get('channels')
                    .then(function(response){
                        console.log(response.data);
                        self.list = response.data;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },

            createChannel: function(){
                console.log('create channel');
                let self = this;
                let params = Object.assign({}, self.channel);
                axios.post('channels/store', params)
                    .then(function(){
                        self.channel.name = '';
                        self.channel.desc = '';
                        self.edit = false;

                        self.fetchChannelList();
                        flash('Added a new channel');
                    })
                    .catch(function(error){
                        console.log(error);
                        // flash(error.response.data, 'danger');
                    });
              
            },

            showChannel: function(id){
                let self = this;
                axios.get('channels/'+ id)
                    .then(function(response){
                        self.channel.id = response.data.id;
                        self.channel.name = response.data.name;
                        self.channel.desc = response.data.desc;

                    })

                    self.edit = true;
            },

            updateChannel: function(id){
                console.log('update '+ id +'channel');
                let self = this;
                let params = Object.assign({}, self.channel);
                axios.patch('channels/'+id, params)
                    .then(function(){
                        self.channel.name = '';
                        self.channel.desc = '';
                        self.edit = false;
                        flash('Updated a channel');
                        self.fetchChannelList();
                        
                    })
                    .catch(function(error){
                        console.log(error);
                        flash(error.response.data, 'danger');
                    });
            },

            deleteChannel: function(id){
                let self = this;
                axios.delete('channels/'+ id)
                    .then(function(response){
                        self.fetchChannelList();
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            }
        }
    }
</script>

