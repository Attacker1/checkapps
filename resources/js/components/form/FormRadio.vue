<template>
    <div>
        <label class="radio-input">
            <input class="radio" :name="name" type="radio" :class="{active : shouldBeChecked}"
                   :checked="shouldBeChecked" :value="value"
                   @change="updateInput">
            <span class="radio-text">{{ value }}</span>
        </label>
    </div>
</template>
<script>
    export default {
        name: "FormRadio",
        model: {
            prop: 'modelValue',
            event: 'change'
        },
        props: {
            name: {
                type: String,
                required: true,
            },
            value: {
                type: String,
            },
            modelValue: {
                default: ""
            },
        },
        computed: {
            shouldBeChecked() {
                return this.modelValue === this.value
            }
        },
        methods: {
            updateInput() {
                this.$emit('change', this.value)
            }
        }
    }
</script>

<style lang="scss" scoped>
    .radio-input {
        display: grid;
        grid-template-columns: 24px 1fr;
        grid-gap: 10px;
        align-items: center;
        margin-bottom: 20px;
        cursor: pointer;
    }

    .radio {
        width: 24px;
        height: 24px;
        visibility: hidden;
        margin: 0;
        position: relative;

        &::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            visibility: visible;
            width: 100%;
            height: 100%;
            border: 1px solid #B8C1CC;
            border-radius: 50%;
            transition: background-color ease 200ms, border-color ease 200ms;
        }

        &::before {
            content: "";
            width: 8px;
            height: 13px;
            position: absolute;
            opacity: 0;
            top: 4px;
            left: 8px;
            border-right: 2px solid white;
            border-bottom: 2px solid white;
            transform: rotate(45deg);
            visibility: visible;
            transition: opacity ease 200ms;
            z-index: 1;
        }

        &.active {
            &::before {
                opacity: 1;
            }

            &::after {
                background-color: black;
                border-color: black;
            }
        }
    }
</style>
