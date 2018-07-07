<template>
<div>
    <div class="level">
        <img :src="avatar" alt="avatar image" class="mr-1" width="50" height="50">
        <h1 v-text="user.name"> </h1>
    </div>
   
    <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
        <image-upload name="avatar" @loaded="onLoad"></image-upload> 
    </form>
  
</div>

</template>

<script>
    import ImageUpload from './ImageUpload.vue';
    export default{
        props: ['user'],

        components:{
            ImageUpload
        },

        data(){
            return{
                avatar: this.user.avatar_path
            };
        },

        computed: {
            canUpdate(){
                return this.authorize(user => user.id === this.user.id);
            }
        },

        methods: {
            onLoad(avatar){
                // console.log('hello');
                // if(! e.target.files.length) retrun;

                // let avatar = e.target.files[0];

                // let reader = new FileReader();

                // reader.readAsDataURL(avatar); 

                // reader.onload = e => {
                //     this.avatar = e.target.result
                // }

                this.avatar = avatar.src;

                //persist to the server
                this.persist(avatar.file);
            },

            persist(avatar){
                let data = new FormData();
                data.append('avatar', avatar);
                axios.post('/api/users/'+this.user.name+'/avatar', data)
                    .then(() => flash('Avatar updated'));
            }
        }

    }

</script>