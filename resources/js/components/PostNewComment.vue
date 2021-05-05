<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="row justify-content-center">
                    <a href="#" class="custom-a" @click.prevent="show = !show">💬 Add new comment 💬</a>
                </div>
                <br v-show="show">
                <div class="card" v-show="show">
                    <div class="alert alert-danger" role="alert" v-if="error">
                        {{ error }}
                    </div>

                    <div class="card-body">
                        <label for="comment">Add your comment:</label>
                        <textarea id="comment" rows="3" maxlength="255" class="form-control" v-model="formData.content"></textarea>
                        <br>
                        <button class="btn btn-primary" @click.prevent="submitted">Send!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['hobby_id'],

    data() {
        return {
            error: null,
            show: false,
            formData: {
                content: ''
            }
        }
    },

    methods: {
        submitted() {
            axios.post(`/api/hobbies/${this.$props.hobby_id}/comment`, this.formData)
                .then(res => {
                    // Force refresh page
                    document.location.reload(true)
                })
                .catch(err => {
                    if (err.response.data.error) {
                        this.error = err.response.data.error.message
                    } else {
                        this.error = err.message;
                    }
                    window.scrollTo(0, 0)
                })
        }
    }
}
</script>
