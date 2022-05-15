<template>
    <div id="page-container">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "sitebody"
}
</script>

<style scoped>
#page-container{
    margin-top: 100px;
    min-height: 100%;
}
</style>
