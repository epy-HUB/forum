<template>
    <!-- <div> -->
        <!-- <li class="dropdown" v-if="notifications.length">
                <a href=""  class="dropdown-toggle" data-toggle="dropdown">
                    <span class="fa fa-5 fa-bell-o"></span>
                </a>
                <ul class="dropdown-menu">
                    <li v-for="notification in notifications">
                        <a :href="notification.data.link" 
                            v-text="notification.data.message"
                            @click="markAsRead(notification)"></a>
                    </li>
                </ul>
            </li> -->
            <li class="dropdown notifications-menu " v-if="notifications.length">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-danger" v-text="notifications.length"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have {{ notifications.length }} notifications</li>
                        <li>
                        <!-- Inner Menu: contains the notifications -->
                        <ul class="menu">
                            <li v-for="notification in notifications">
                                    <a :href="notification.data.link" 
                                        v-text="notification.data.message"
                                        @click="markAsRead(notification)"></a>
                                </li>
                            <!-- end notification -->
                        </ul>
                        </li>
                    </ul>
                </li>
    <!-- </div> -->
    
</template>




<script>
    export default{
        data(){
            return {
                notifications: false
            };
        },

        created(){
            axios.get('/profiles/'+ window.App.user.name +'/notifications')
            .then(
                response => this.notifications = response.data, 
            );
        },

        methods: {
            markAsRead(notification){
                axios.delete('/profiles/'+ window.App.user.name +'/notifications/'+ notification.id)
           
            }
        }
    }
</script>