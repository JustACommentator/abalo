<template>
    <div>
        <!-- Header -->
        <nav>
            <siteheader v-on:sendToShoppingCart="selectContent">
                <a class="nav-link" v-on:click="this.selectContent('articles')">Home</a>
                <a class="nav-link" v-on:click="this.selectContent('new-article')">New Article</a>
            </siteheader>
        </nav>

        <!-- Body -->

        <sitebody>
            <div v-if="this.selected_content === 'articles' ">
                <articlesearch></articlesearch>
            </div>
            <div v-else-if="this.selected_content === 'new-article' ">
                <newarticle></newarticle>
            </div>
            <div v-else-if="this.selected_content === 'impressum'">
                <impressum></impressum>
            </div>
            <div v-else-if="this.selected_content === 'shoppingCart'">
                <shoppingcart></shoppingcart>
            </div>
        </sitebody>

        <!-- Footer -->
        <footer>
            <sitefooter>
                <a class="nav-link" v-on:click="this.selectContent('impressum')">Impressum</a>
            </sitefooter>
        </footer>

    </div>
</template>

<script>
import articlesearch from "./ArticleSearch";
import siteheader from "../Components/siteheader";
import sitebody from "../Components/sitebody";
import sitefooter from "../Components/sitefooter";
import newarticle from "../Components/newarticle";
import impressum from "../Components/impressum";
import shoppingcart from "../Components/shoppingcart";

export default {
    components:{
        articlesearch, sitebody, sitefooter, siteheader, newarticle, impressum, shoppingcart
    },
    data(){
        return {
            selected_content : this.selectedContent
        }
    },
    props: {
        selectedContent : {
            String,
            default: 'articles'
        }
    },
    methods: {
        selectContent(content){
            this.selected_content = content
        }
    }
}
</script>

<style scoped>
    footer{
        position: relative;
        bottom: 0;
        width: 100%;
        margin-top: 100px;
    }
    a:hover{
        cursor: pointer;
    }
</style>
