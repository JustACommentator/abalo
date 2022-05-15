<template>
    <div class="navbar navbar-expand-lg bg-light fixed-top">
        <div class="container-fluid">
            <div class="align-items-start">
                <p>Abalo</p>
            </div>
            <div class="align-items-end navbar">
                <a class="nav-link fa" style="font-size:24px" v-on:click="this.toggleShoppingCart()">&#xf07a;</a>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
import shoppingcart from "./shoppingcart";
export default {
    name: "siteheader",
    components:{
        shoppingcart
    },
    data(){
        return {
            showShoppingCart : false
        }
    },
    props: {
        counter : {String, default: 0 }
    },
    methods:{
        toggleShoppingCart(){
           this.$emit('sendToShoppingCart', 'shoppingCart')
        }
    }
}
</script>

<style scoped>
a:hover{
    cursor: pointer;
}

</style>
