<template>
    <div class="navbar navbar-expand-lg bg-light fixed-top">
        <div class="container-fluid">
            <div class="align-items-start">
                <p>Abalo</p>
            </div>
            <div class="align-items-end navbar">
                <a class="nav-link fa" style="font-size:24px" v-on:click="this.toggleShoppingCart()">&#xf07a;</a>
                <span class='badge badge-warning' id='lblCartCount'> {{this.shoppingCartCounter}} </span>
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
            shoppingCartCounter : this.counter,
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
#lblCartCount {
    font-size: 12px;
    background: #ff0000;
    color: #fff;
    padding: 0 5px;
    vertical-align: top;
    margin-left: -10px;
}
.badge {
    padding-left: 9px;
    padding-right: 9px;
    -webkit-border-radius: 9px;
    -moz-border-radius: 9px;
    border-radius: 9px;
}
</style>
