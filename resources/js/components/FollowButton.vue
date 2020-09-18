<template>
    <div class="container">
        <button class="btn btn-primary ml-3" v-on:click="FollowUser()" v-text="buttonText"></button>
    </div>
</template>

<script>
    export default {
        props : ['userId','follows'],
        mounted() {
            console.log('Component mounted.')
        },
        data : function() {
                return {
                    status : this.follows,
                }
        },
        methods:{
            FollowUser(){
                axios({
                    'method' : 'post',
                    'url' : '/follow/'+this.userId
                    })
                .then(res => {
                    this.status = ! this.status;
                })
                .catch(error => {
                    if(error.response.status == 401)
                    {
                        window.location ='/login';
                    }
                });
            }
        },
        computed:{
            buttonText()
            {
                return (this.status) ? 'Unfollow' : 'Follow' ;
            }
        }
    }
</script>
