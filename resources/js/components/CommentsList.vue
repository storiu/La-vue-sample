<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card" v-if="comments.length > 0">
                        <div class="card-body">
                            <comments-list-item v-for="item in comments" :key="item.id" :comment="item"></comments-list-item>
                        </div>
                    </div>

                    <div v-if="comments.length == 0" class="row justify-content-center no-data">
                        <em>There's no comments yet!</em>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['comments']
}
</script>
