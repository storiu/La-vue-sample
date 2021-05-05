<template>
    <div class="container">
        <div v-if="loading">
            Loading...
        </div>

        <div class="alert alert-danger" v-if="error">
            {{ error }}
        </div>

        <div v-if="usersList">
            Users list
            <table class="table table-striped">
                <thead>
                    <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Avatar</td>
                    <td>Is Admin</td>
                    <td colspan="2">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in usersList" :key="item.id">
                        <td>{{item.id}}</td>
                        <td>{{item.name}}</td>
                        <td>{{item.nickname}}</td>
                        <td>{{item.email}}</td>
                        <td><img :src="$store.getters.getProfileLink(item)" class="rounded-circle image-keep-ratio" width="40" height="40" /></td>
                        <td>{{item.is_admin}}</td>
                        <td><a :href="`/admin/users/${item.id}/edit`">Edit</a></td>
                        <td><button><a href="#" @click.prevent="deleteUser(item.id)">Delete</a></button></td>
                    </tr>
                </tbody>
            </table>

            <pagination :currentPage="pagination.curPage" :totalPages="pagination.totalPages" @changePage="loadPage"></pagination>
       </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: true,
            error: null,
            usersList: null,
            pagination: null
        }
    },

    mounted() {
        this.loadPage(1)
    },

    methods: {
        loadPage(page) {
            this.loading = true;

            axios.get(`/api/admin/users?page=${page}`)
                .then(res => {
                    this.loading = false;
                    this.usersList = res.data.users;
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

        deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                axios.delete(`/api/admin/users/${id}/delete`)
                    .then(res => {
                        document.location.reload(true)
                    })
                    .catch(err => {
                        this.loading = false;
                        if (err.response.data.error) {
                            this.error = err.response.data.error.message
                        } else {
                            this.error = err.message;
                        }
                    })
            }
        }
    },
}
</script>
