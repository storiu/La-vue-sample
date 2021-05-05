<template>
    <div>
        <div class="container">
            <div class="row item">
                <div class="col-auto">
                    <img :src="$store.getters.getProfileLink(hobby.author)" class="rounded-circle image-keep-ratio" width="60" height="60" />
                </div>
                <div class="col">
                    <h6>
                        <a :href="`/users/${hobby.author.nickname}`">
                            {{hobby.author.name}} @{{hobby.author.nickname}}
                        </a>
                    </h6>

                    <div class="row">
                        <a :href="`/categories/${category.id}`">
                            {{ category.icon }}
                            {{ category.name }}
                        </a>
                        <p class="date">{{ hobby.date }}</p>
                    </div>
                    <h3>{{ hobby.title }}</h3>
                    <p>{{ hobby.description }}</p>

                    <div v-if="hobby.photo">
                        <img :src="`/images/posts/${hobby.photo}`" class="image-keep-ratio" width="100%" height="300">
                    </div>
                    <br>

                    <a :href="`/hobby/${hobby.id}`">
                        <b>{{ hobby.commentsNb }}</b> comments&nbsp;💬
                    </a>
                </div>
                <div class="col-auto">
                    <h3>{{ hobby.rating }}/10</h3>
                </div>
            </div>
        </div>
        <hr>
    </div>
</template>

<script>
export default {
    props: ['hobby'],

    computed: {
        category() {
            return this.$store.getters.getCategory(this.hobby.category_id)
        }
    }
}
</script>

<style scoped>
    .date {
        margin-left: 20px;
    }

    .row.item:hover {
        background-color:#f9f9f9;
    }
</style>
