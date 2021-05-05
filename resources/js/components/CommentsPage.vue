<template>
    <div class="container">
        <div v-if="loading">
            Loading...
        </div>

        <div v-if="error">
            {{ error }}
        </div>

        <div v-if="commentsData">
            <post-new-comment :hobby_id="hobby_id"></post-new-comment>
            <br>
            <comments-list :comments="commentsData"></comments-list>
            <br>
            <pagination v-if="commentsData.length > 0" :currentPage="pagination.curPage" :totalPages="pagination.totalPages" @changePage="loadPage"></pagination>
        </div>
    </div>
</template>

<script>
export default {
    props: ['hobby_id'],

    data() {
        return {
            loading: true,
            error: null,
            commentsData: null,
            pagination: null
        }
    },

    mounted() {
        this.loadPage(1)
    },

    methods: {
        loadPage(page) {
            this.loading = true;

            axios.get(`/api/hobbies/${this.$props.hobby_id}/comments?page=${page}`)
                .then(res => {
                    this.loading = false
                    this.commentsData = res.data.comments;
                    this.pagination = res.data.pagination;
                })
                .catch(err => {
                    this.loading = false;
                    if (err.response.data.error) {
                        this.error = err.response.data.error.message
                    } else {
                        this.error = err.message;
                    }
                })
            },
    }

}
</script>
