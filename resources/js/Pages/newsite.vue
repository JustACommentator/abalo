<template>
    <div>
<!--         Header -->
                <nav>
                    <siteheader v-on:sendToShoppingCart="selectContent">
                        <a class="nav-link" v-on:click="this.selectContent('articles')">Home</a>
                        <a class="nav-link" v-on:click="this.selectContent('new-article')">New Article</a>
                        <a class="nav-link" v-on:click="this.testLogin(false)">Login</a>
                        <a class="nav-link" v-on:click="this.testLogin(true)">Test Login</a>
                    </siteheader>
                </nav>

        <!--  Extra Komponent für das Video-->
        <test></test>

        <!-- Body -->

        <sitebody class="container">
            <div v-if="has_servicing_msg" class="alert alert-info" role="alert">
                {{ this.servicing_msg }}
            </div>

            <div v-if="this.selected_content === 'articles' ">
                <articlesearch :own_articles="this.ownArticles"
                               :promotion-socket="this.promotion_socket"></articlesearch>
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
import test from "../Components/test";


export default {
    components: {
        test , articlesearch, sitebody, sitefooter, siteheader, newarticle, impressum, shoppingcart
    },
    mounted() {
        this.testLogin(false)
        //this.warning()
        //this.selling()
    },
    data: function () {
        //let warningSocket = new WebSocket('ws://localhost:8080/chat')
        //let sellingSocket = new WebSocket('ws://localhost:8090/chat')
        let socket = new WebSocket('ws://localhost:8080/chat')
        return {
            selected_content: this.selectedContent,
            servicing_msg: '',
            has_servicing_msg: false,
            current_user: '',
            //warning_socket: warningSocket,
            //selling_socket: sellingSocket
            promotion_socket: socket,
            ownArticles: []
        }
    },
    props: {
        selectedContent: {
            String,
            default: 'articles'
        }
    },
    methods: {
        selectContent(content) {
            this.selected_content = content
        },


        async testLogin(visitor) {
            await axios.post('/login', {
                'visitor': visitor
            })

            const {data} = await axios.get('/isloggedin')
            this.current_user = data['user']

            if (this.selling_socket) {
                this.selling_socket.send(JSON.stringify({
                    'type': 'register_user',
                    'user_id': this.current_user
                }))
            }

            let url = 'api/own-articles'
            await axios.post(url, {
                'name': this.current_user
            }).then(response => {
                this.ownArticles = response.data
            }).catch(e => {
                console.log(e)
            })

        },

        warning() {

            this.warning_socket.onopen = (event) => {
                console.log('Connection established');
            }

            this.warning_socket.onclose = (event) => {
                console.log('Connection closes');
            }

            this.warning_socket.onmessage = (messageEvent) => {
                console.log(this.servicing_msg)
                try {
                    this.servicing_msg = messageEvent['data']
                    this.has_servicing_msg = true
                } catch (err) {
                    console.log('Error: ', err.message)
                }

            }
        },
        selling() {
            this.selling_socket.onopen = (event) => {
                console.log('Connection established');
            }

            this.selling_socket.onclose = (event) => {
                console.log('Connection closes');
            }

            this.selling_socket.onmessage = (messageEvent) => {
                try {
                    console.log(messageEvent.data)
                    this.servicing_msg = messageEvent.data
                    this.has_servicing_msg = true
                } catch (err) {
                    console.log('Error: ', err.message)
                }
            }
        },
    }
}
</script>

<style scoped>
footer {
    position: relative;
    bottom: 0;
    width: 100%;
    margin-top: 100px;
}

a:hover {
    cursor: pointer;
}
</style>
