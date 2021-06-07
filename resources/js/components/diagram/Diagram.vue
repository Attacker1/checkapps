<template>
    <div class="diagram">
        <svg class="diagram__chart" width="120" height="120" viewBox="0 0 50 50">
            <circle class="diagram__unit" r="15.9" cx="50%" cy="50%" ></circle>
            <circle class="diagram__unit" r="15.9" cx="50%" cy="50%" :stroke-dashoffset="-sucsessCount"></circle>
        </svg>
    </div>
</template>
<script>
    export default {
        name: 'Diagram',
        props: {
            sucsessCount: {
                type: Number,
                default: 50
            }
        }
    }
</script>
<style lang="scss" scoped>
    .diagram {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 120px;
        max-height: 120px;

        &__unit {
            fill: none;
            stroke-width: 10;

            &:nth-child(1) {
                stroke: #0071e3;
                stroke-dasharray: 8100;
            }

            &:nth-child(2) {
                stroke: #ee5a2b;
                stroke-dasharray: 11100;
            }
        }
    }
</style>
