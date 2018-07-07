<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue';
    export default{
        props: ['thread'],

        components: {
            Replies,
            SubscribeButton
        },

        data(){
            return {
                repliesCount: this.thread.replies_count,
                editing: false,
                title: this.thread.title,
                body: this.thread.body,
                form: {
                    title: this.thread.title,
                    body: this.thread.body
                }
               
                
            };
        },

        created(){
            this.resetForm();
            
        },  
        
        computed: {


                signedIn(){
                    return window.App.signedIn;
                },

                isAdmin(){
                    return this.authorize(isAdmin());
                    // return this.data.user_id == window.App.user.id;
                }
        },

        methods: {
            update(){
                axios.patch('/threads/' + this.thread.channel.slug + '/' + this.thread.slug, {
                    title: this.form.title,
                    body: this.form.body
                }).then(() => {
                    this.editing=false;
                    this.title = this.form.title;
                    this.body = this.form.body;
                    flash('Your thread has been updated')
                })

            },
            resetForm(){
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body
                };

                this.editing=false;
            }
        }
    }

    
</script>