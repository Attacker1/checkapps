<template>
    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g filter="url(#filter0_bzoom)">
            <rect width="48" height="48" rx="24" fill="black" fill-opacity="0.24"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M22 30C17.5817 30 14 26.4183 14 22C14 17.5817 17.5817 14 22 14C26.4183 14 30 17.5817 30 22C30 23.8487 29.3729 25.551 28.3199 26.9056L33.7071 32.2929L32.2929 33.7071L26.9056 28.3199C25.551 29.3729 23.8487 30 22 30ZM28 22C28 25.3137 25.3137 28 22 28C18.6863 28 16 25.3137 16 22C16 18.6863 18.6863 16 22 16C25.3137 16 28 18.6863 28 22Z"
                  fill="white"/>
        </g>
        <defs>
            <filter id="filter0_bzoom" x="-4" y="-4" width="56" height="56" filterUnits="userSpaceOnUse"
                    color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                <feGaussianBlur in="BackgroundImage" stdDeviation="2"/>
                <feComposite in2="SourceAlpha" operator="in" result="effect1_backgroundBlur"/>
                <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur" result="shape"/>
            </filter>
        </defs>
    </svg>

</template>

<script>
    export default {
        name: "IconZoom"
    }
</script>

<style scoped>

</style>
