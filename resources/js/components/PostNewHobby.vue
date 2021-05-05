<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="row justify-content-center">
                    <a href="#" class="custom-a" @click.prevent="show = !show">🌟 Add new hobby 🌟</a>
                </div>
                <br v-show="show">
                <div class="card" v-show="show">
                    <div class="alert alert-danger" role="alert" v-if="error">
                        {{ error }}
                    </div>
                    <div class="card-body">
                        <label for="category">Category:</label>
                        <select id="category" class="form-control" v-model="formData.categoryId">
                            <option value="null">-- Choose your category --</option>
                            <option v-for="category in $store.state.categories" :value="category.id" :key="category.id">{{category.icon}}&nbsp;&nbsp;{{ category.name }}</option>
                        </select>

                        <br>
                        <label for="title">Title:</label>
                        <input type="text" id="title" class="form-control" maxlength="255" v-model="formData.title">

                        <br>
                        <label for="description">Description:</label>
                        <textarea id="description" rows="3" maxlength="255" class="form-control"
                                  v-model="formData.description"></textarea>

                        <br>
                        <label for="rating">Rating:</label>
                        <select id="rating" class="form-control" v-model="formData.rating">
                            <option value="null">-- Rate your hobby --</option>
                            <option value=10>10 Best ever</option>
                            <option value=9>09 Excellent</option>
                            <option value=8>08 Very good</option>
                            <option value=7>07 Fine</option>
                            <option value=6>06 OK</option>
                            <option value=5>05 Average</option>
                            <option value=4>04 Bad</option>
                            <option value=3>03 Very bad</option>
                            <option value=2>02 Horrible</option>
                            <option value=1>01 Abonimable</option>
                            <option value=0>00 Worst ever</option>
                        </select>

                        <br>
                        <label for="photo">Optional photo:</label><br>
                        <input type="file" id="photo" class="custom-input"
                            @change="imageChanged" accept="image/png, image/jpeg">

                        <br><br>
                        <button class="btn btn-primary" @click.prevent="submitted">Send!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['categoryId'],

    data() {
        return {
            error: null,
            show: false,
            formData: {
                categoryId: this.$props.categoryId ?? null,
                title: '',
                description: '',
                rating: null,
                photo: null
            }
        }
    },

    methods: {
        submitted() {
            axios.post('/api/hobbies/add', this.formData)
                .then(res => {
                    // Force refresh page
                    document.location.reload(true)
                })
                .catch(err => {
                    if (err.response.data.error) {
                        this.error = err.response.data.error.message
                    } else {
                        this.error = err.message
                    }
                    window.scrollTo(0, 0)
                })
        },

        imageChanged(e) {
            let selectedImage = e.target.files[0]

            let reader = new FileReader()
            reader.readAsDataURL(selectedImage)
            reader.onload = (e) => {
                this.formData.photo = e.target.result
            }
        }
    }
}
</script>
