<template>
    <div class="container">
        <div v-if="loading">
            Loading...
        </div>

        <div v-if="error">
            {{ error }}
        </div>

        <div v-if="categoriesData">
            <div class="row justify-content-center">
                <h2 class="strait">{{ categoriesData.category.icon }} {{ categoriesData.category.name }}</h2>
            </div>

            <post-new-hobby :categoryId="$props.id"></post-new-hobby>
            <br>
            <hobbies-list :hobbies="categoriesData.hobbies"></hobbies-list>
            <br>
            <pagination v-if="categoriesData.hobbies.length > 0" :currentPage="pagination.curPage" :totalPages="pagination.totalPages" @changePage="loadPage"></pagination>
        </div>
    </div>
</template>

<script>
export default {
    props: ['id'],

    data() {
        return {
            loading: true,
            error: null,
            categoriesData: null,
            pagination: null
        }
    },
    mounted() {
        this.loadPage(1)
    },
    methods: {
        loadPage(page) {
            this.loading = true

            axios.get(`/api/categories/${this.id}/hobbies?page=${page}`)
                .then(res => {
                    this.loading = false
                    this.categoriesData = res.data
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
