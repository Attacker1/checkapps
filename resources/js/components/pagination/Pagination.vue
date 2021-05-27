<template>
    <div>
        <div class="pagination">
            <div @click="changePagePagination(link)" v-for="(link, i) in links"
                 :key="link + i"
                 class="pagination__item"
                 :class="{active: link.active}" v-html="replacePaginate(link.label)"/>
        </div>
    </div>
</template>

<script>
export default {
    name: "Pagination",
    props: {
        links: null,
    },
    methods: {
        replacePaginate(label) {
            if (label.includes('Previous')) {
                return '«'
            } else if (label.includes('Next')) {
                return '»'
            }
            return label;
        },

        changePagePagination(link) {
            this.$emit('change-page', {link})
        }
    }
}
</script>

<style lang="scss" scoped>
.pagination {
    margin-top: 50px;
    display: grid;
    grid-template-columns: repeat(auto-fill, 40px);
    grid-gap: 0.5em;
    justify-content: center;
    width: 100%;

    &__item {
        width: 40px;
        height: 40px;
        border-radius: 4px;
        border: 2px solid #c4c4c4;
        color: $primary;
        transition: background-color ease 200ms, border-color ease 200ms;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;

        &:hover {
            background-color: rgba($primary, 0.1);
        }

        &.active {
            background-color: $primary;
            border-color: $primary;
            color: white;
        }
    }
}
</style>
