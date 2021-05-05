<template>
    <div>
        <div class="container">
            <div class="row item">
                <div class="col-auto">
                    <img :src="$store.getters.getProfileLink(comment.author)" class="rounded-circle image-keep-ratio" width="60" height="60" />
                </div>
                <div class="col">
                    <h6>
                        <a :href="`/users/${comment.author.nickname}`">
                            {{comment.author.name}} @{{comment.author.nickname}}
                        </a>
                    </h6>

                    <p>{{ comment.content }}</p>
                </div>
            </div>
        </div>
        <hr>
    </div>
</template>

<script>
export default {
    props: ['comment'],
}
</script>

<style scoped>
    .row.item:hover {
        background-color:#f9f9f9;
    }
</style>
