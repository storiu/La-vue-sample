<template>
    <div class="container">
        <div v-if="loading">
            Loading...
        </div>

        <div v-if="error">
            {{ error }}
        </div>

        <div v-if="userInfo">
            <user-info :user="userInfo.user"></user-info>
            <br>
            <hobbies-list :hobbies="userInfo.hobbies"></hobbies-list>
            <br>
            <pagination v-if="userInfo.hobbies.length > 0" :currentPage="pagination.curPage" :totalPages="pagination.totalPages" @changePage="loadPage"></pagination>
        </div>
    </div>
</template>

<script>
export default {
    props: ['username'],

    data() {
        return {
            loading: true,
            error: null,
            userInfo: null,
            pagination: null
        }
    },

    mounted() {
        this.loadPage(1)
    },

    methods: {
        loadPage(page) {
            this.loading = true

            axios.get(`/api/users/${this.username}?page=${page}`)
                .then(res => {
                    this.loading = false
                    this.userInfo = res.data
                    this.pagination = res.data.pagination
                })
                .catch(err => {
                    this.loading = false
                    if (err.response.data.error) {
                        this.error = err.response.data.error.message
                    } else {
                        this.error = err.message
                    }
                })
            },
    }
}
</script>
