<template>
    <div class="row justify-content-center">
        <ul class="pagination">
            <li v-bind:class="getCssLiClass(0)">
                <a class="page-link" href="#" @click.prevent="changePage(0)" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <li v-for="(curPage, index) in getPagesArray()" :key="index" v-bind:class="getCssLiClass(index + 1)"><a class="page-link" href="#" @click.prevent="changePage(index + 1)">{{ curPage }}</a></li>

            <li v-bind:class="getCssLiClass(7)">
                <a class="page-link" href="#" @click.prevent="changePage(7)" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ['currentPage', 'totalPages'],

    methods: {
        getPagesArray() {
            let length = Math.min(this.$props.totalPages, 6)
            let startFrom = this.getStartFrom();

            // index in [0 to (length - 1)] included
            return Array.from({length: length}, (_, index) =>
                index + startFrom
            )
        },

        getStartFrom() {
            let startFrom = 1

            if (this.$props.currentPage > 2 && this.$props.currentPage < this.$props.totalPages - 2) {
                startFrom = Math.max(1, this.$props.currentPage - 2)
            } else if (this.$props.currentPage + 3 > this.$props.totalPages) {
                startFrom = Math.max(1, this.$props.totalPages - 5)
            }

            return startFrom
        },

        changePage(page) {
            let newPage;

            // Previous
            if (page == 0) {
                newPage = this.$props.currentPage - 1
            }

            // Default pages
            if (page > 0 && page < 7) {
                newPage = page + this.getStartFrom() - 1
            }

            // Next
            if (page == 7) {
                newPage = this.$props.currentPage + 1
            }

            this.$emit('changePage', newPage)
            window.scrollTo(0, 0)
        },

        getCssLiClass(page) {
            let active = false;
            let disabled = false;

            // Previous
            if (page == 0) {
                disabled = this.$props.currentPage == 1
            }

            // Default pages
            if (page > 0 && page < 7) {
                active = (this.$props.currentPage - this.getStartFrom() + 1) == page
            }

            // Next
            if (page == 7) {
                disabled = this.$props.currentPage == this.$props.totalPages
            }

            return {
                'page-item': true,
                'active': active,
                'disabled': disabled
            }
        }
    }
}
</script>
