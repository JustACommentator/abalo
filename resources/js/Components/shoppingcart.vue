<template>
    <div  class="container" >
        <div class="row p-2 bg-light border">
            <div class="col lign-items-center justify-content-center">
                <p class="text-center">Name</p>
            </div>
            <div class="col lign-items-center justify-content-center">
                <p class="text-center">Price</p>
            </div>
            <div class="col lign-items-center justify-content-center">
                Total: {{ this.totalPrice }}
            </div>
        </div>
        <div class="row bg-light border" v-for="item in shoppingCartItems">
            <div class="col lign-items-center justify-content-center">
                <p>{{ item[0]['ab_name'] }}</p>
            </div>
            <div class="col lign-items-center justify-content-center">
                <p>{{ item[0]['ab_price'] }}</p>
            </div>
            <div class="col lign-items-center justify-content-center">
                <a class="nav-link" v-on:click="deleteFromShoppingCart(item[0]['id'])">Delete from shopping cart</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "shoppingcart",
    mounted(){
        this.getCurrentShoppingCart()
    },
    data(){
        return {
            shoppingCartItems: [],
            shoppingCartID : 0,
            totalPrice : 0,
        }
    },
    methods: {
        async getCurrentShoppingCart(){
            const { data } = await axios.get('/api/currentShoppingCart')
            this.shoppingCartItems = data['items']
            this.shoppingCartID = data['id']

            let price = 0
            this.shoppingCartItems.forEach(item => price += item[0]['ab_price'])

            this.totalPrice = price
        },

        async deleteFromShoppingCart(articleID){
            let url = '/api/shoppingcart/' + this.shoppingCartID + '/articles/' + articleID
            console.log(url)
            await axios.delete(url)

            await this.getCurrentShoppingCart()
        },

    }
}
</script>

<style scoped>

</style>
