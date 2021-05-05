<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <img :src="$store.getters.getProfileLink(user)" class="rounded-circle image-keep-ratio" width="120" height="120" />
                                </div>

                                <div class="col">
                                    <h4>{{user.name}}</h4>
                                    <h6>@{{user.nickname}}</h6>

                                    <h6 v-if="!small"><a :href="`/users/${user.id}/following`"><b>{{user.following}}</b> following</a></h6>
                                    <h6 v-if="!small"><a :href="`/users/${user.id}/followers`"><b>{{user.followers}}</b> followers</a></h6>

                                    <div class="row">
                                        <follow-button :id="user.id" :isFollowed="user.followed" @followed="updateFollowed" v-if="!small"></follow-button>&nbsp;&nbsp;
                                        <unfollow-button :id="user.id" :isFollowed="user.followed" @followed="updateFollowed" v-if="!small"></unfollow-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['user', 'small'],

    methods: {
        updateFollowed(followed) {
            this.$props.user.followed = followed
        }
    }
}
</script>
