<template>
    <div>
        <h1 v-if="!edit">Add Channel</h1>
        <h1 v-else>Update Channel</h1>
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
        <table class="table table-bordered table-stroped">
            <thead>
                    <th>Name</th>
                    <th>Action</th>
                    <!-- <th>Delete</th> -->
            </thead>
            <tbody>
                <tr v-for="channel in list" >
                    <td>{{ channel.name }}</td>
                    <td> <button @click="showChannel(channel.id)" class="btn btn-info btn-xs">Edit</button>
                    <button @click="deleteChannel(channel.id)" class="btn btn-danger btn-xs">Delete</button></td>
                </tr>
            </tbody>
            
        </table>
        <!-- <ul class="list-group">
            <li v-for="channel in list" class="list-group-item">
                {{ channel.name }}
                <button @click="showChannel(channel.id)" class="btn btn-default btn-xs">Edit</button>
                <button @click="deleteChannel(channel.id)" class="btn btn-danger btn-xs">Delete</button>
            </li>
        </ul> -->
    </div>
</template>

<script>
    export default{
        props: ['channels'],
        data(){
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

        mounted(){
            console.log('channel component loaded');
            this.fetchChannelList();
        },

        methods: {
            fetchChannelList(){
                console.log('fetching  contacts');
                let self = this;
                axios.get('channels')
                    .then((response)=>{
                        console.log(response.data);
                        self.list = response.data;
                    })
                    .catch((error)=>{
                        console.log(error);
                    });
            },

            createChannel(){
                console.log('create channel');
                let self = this;
                let params = Object.assign({}, self.channel);
                axios.post('channels/store', params)
                    .then(()=>{
                        self.channel.name = '';
                        self.channel.desc = '';
                        self.edit = false;

                        self.fetchChannelList();
                        flash('Added a new channel');
                    })
                    .catch((error)=>{
                        console.log(error);
                        // flash(error.response.data, 'danger');
                    });
              
            },

            showChannel(id){
                let self = this;
                axios.get('channels/'+ id)
                    .then((response)=>{
                        self.channel.id = response.data.id;
                        self.channel.name = response.data.name;
                        self.channel.desc = response.data.desc;

                    })

                    self.edit = true;
            },

            updateChannel(id){
                console.log('update '+ id +'channel');
                let self = this;
                let params = Object.assign({}, self.channel);
                axios.patch('channels/'+id, params)
                    .then(()=>{
                        self.channel.name = '';
                        self.channel.desc = '';
                        self.edit = false;
                        flash('Updated a channel');
                        self.fetchChannelList();
                        
                    })
                    .catch((error)=>{
                        console.log(error);
                        flash(error.response.data, 'danger');
                    });
            },

            deleteChannel(id){
                let self = this;
                axios.delete('channels/'+ id)
                    .then((response)=>{
                        self.fetchChannelList();
                    })
                    .catch((error)=>{
                        console.log(error);
                    });
            }
        }
    }
</script>

