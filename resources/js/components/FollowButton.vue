<template>
    <div>
        <button v-show="!isFollowed" type="button" class="btn btn-primary btn-sm" @click="follow()">Follow</button>
        <button v-show="isFollowed" type="button" class="btn btn-primary btn-sm" disabled>Followed!</button>
    </div>
</template>

<script>
export default {
    props: ['id', 'isFollowed'],

    methods: {
        follow() {
            axios.post(`/api/users/${this.id}/follow`, this.formData)
                .then(res => {
                    this.$emit('followed', true)
                })
                .catch(err => {
                })
        }
    }
}
</script>
