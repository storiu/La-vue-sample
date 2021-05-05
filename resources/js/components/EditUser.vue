<template>
    <div class="container">
        <div v-if="loading">
            Loading...
        </div>

        <div v-if="error">
            {{ error }}
        </div>

        <div v-if="userData">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">

                            <div v-if="formError" class="alert alert-danger" role="alert">
                                {{ formError }}
                            </div>

                            <label for="name">Name: </label>
                            <input type="text" id="name" class="form-control"
                                   v-model="userData.name">
                            <br>
                            <label for="nickname">Username: </label>
                            <input type="text" id="nickname" class="form-control"
                                    v-model="userData.nickname">
                            <br>
                            <label for="email">Email: </label>
                            <input type="email" id="email" class="form-control"
                                    v-model="userData.email">
                            <br>
                            <label for="password">Password: </label>
                            <input type="password" id="password" class="form-control"
                                    v-model="userData.password" placeholder="Leave empty to keep current password">
                            <br>
                            <label for="avatar">Avatar: </label>
                            <br>

                            <div class="row align-items-end">
                                &nbsp;&nbsp;
                                <img :src="oldAvatar" class="rounded-circle image-keep-ratio" width="80" height="80" />
                                &nbsp;&nbsp;

                                <input type="file" id="avatar" class="custom-input"
                                    @change="imageChanged" accept="image/png, image/jpeg">
                            </div>

                            <br>
                            <div v-if="$props.admin">
                                <br>
                                <label for="is_admin">Is admin: </label>

                                <div class="form-group row">
                                    <div class="col-lg">
                                        <input type="radio" id="is_admin" v-bind:value="true"
                                            v-model="userData.is_admin">
                                        <label for="is_admin">Yes</label>
                                        <input type="radio" id="not_admin" v-bind:value="false"
                                            v-model="userData.is_admin">
                                        <label for="not_admin">No</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-primary" @click.prevent="submitted">Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['id', 'admin'],

    data() {
        return {
            loading: true,
            error: null,
            formError: null,
            userData: null,
            oldAvatar: null
        }
    },

    methods: {
        imageChanged(e) {
            let selectedImage = e.target.files[0]

            let reader = new FileReader()
            reader.readAsDataURL(selectedImage)
            reader.onload = (e) => {
                this.userData.avatar = e.target.result
            }
        },

        submitted() {
            let url;
            if (this.$props.admin) {
                url = `/api/admin/users/${this.$props.id}/edit`
            } else {
                url =  `/api/users/${this.$props.id}/edit`
            }

            axios.put(url, this.userData)
                .then(res => {
                    this.loading = false

                    let url;
                    if (this.$props.admin) {
                        url = '/admin/users'
                    } else {
                        url = '/users/me/edit'
                    }
                    window.location.replace(url)
                })
                .catch(err => {
                    this.loading = false
                    if (err.response.data.error) {
                        this.formError = err.response.data.error.message
                    } else {
                        this.formError = err.message
                    }

                    // Scroll to the top to see errors
                    window.scrollTo(0, 0)
                })
        }
    },

    mounted() {
        let url;
        if (this.$props.admin) {
            url =  `/api/admin/users/${this.$props.id}`
        } else {
            url =  `/api/users/id/${this.$props.id}`
        }

        axios.get(url)
            .then(res => {
                this.loading = false
                this.userData = res.data
                this.oldAvatar = this.$store.getters.getProfileLink(this.userData)
                this.userData.avatar = null
            })
            .catch(err => {
                this.loading = false
                if (err.response.data.error) {
                    this.error = err.response.data.error.message
                } else {
                    this.error = err.message
                }
            })
    }
}
</script>
