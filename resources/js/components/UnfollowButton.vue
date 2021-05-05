<template>
    <div>
        <button v-show="isFollowed" type="button" class="btn btn-danger btn-sm" @click="unfollow()">Unfollow</button>
    </div>
</template>

<script>
export default {
    props: ['id', 'isFollowed'],

    methods: {
        unfollow() {
            axios.delete(`/api/users/${this.id}/unfollow`, this.formData)
                .then(res => {
                    this.$emit('followed', false)
                })
                .catch(err => {
                })
        }
    }
}
</script>
