<template>
    <div id="footer" class="bg-dark fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-5 col-md-6 text-white text-start">
                    <p>Martin Bende & Tarik Glasmacher</p>
                </div>
                <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0 text-end text-white">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "sitefooter"
}
</script>

<style scoped>
#footer {
}
</style>
