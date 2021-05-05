<template>
    <div class="container">
        <div v-if="loading">
            Loading...
        </div>

        <div v-if="error">
            {{ error }}
        </div>

        <div v-show="latest.hobbies.length > 0">
            <div class="row justify-content-center strait">
                <h2>🏠 {{ username}}'s Home</h2>
            </div>

            <post-new-hobby></post-new-hobby>
            <br>
        </div>

        <!-- Welcome component shown only when there's no data (first usage) -->
        <welcome v-if="latest.hobbies.length == 0"></welcome>

        <div v-if="latest.hobbies.length > 0">
            <hobbies-list :hobbies="latest.hobbies"></hobbies-list>
            <br>
            <pagination v-if="latest.hobbies.length > 0" :currentPage="pagination.curPage" :totalPages="pagination.totalPages" @changePage="loadPage"></pagination>
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
            latest: null,
            pagination: null
        }
    },

    mounted() {
        this.loadPage(1)
    },

    methods: {
        loadPage(page) {
            this.loading = true

            axios.get(`/api/hobbies/latest?page=${page}`)
                .then(res => {
                    this.loading = false
                    this.latest = res.data
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
