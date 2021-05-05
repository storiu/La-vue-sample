<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card" v-if="hobbies.length > 0">
                        <div class="card-body">
                            <hobbies-list-item v-for="item in hobbies" :key="item.id" :hobby="item"></hobbies-list-item>
                        </div>
                    </div>

                    <div v-if="hobbies.length == 0" class="row justify-content-center no-data">
                        <em>There's no hobbies yet!</em>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['hobbies']
}
</script>
