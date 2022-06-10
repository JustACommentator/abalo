<template>
    <div>
        <div class="container">
            <label class="form-label" for="search">Search</label>
            <input id="search" v-model="searchInput" class="form-control" placeholder="Please enter a article"
                   type="text">
        </div>
        <div v-if="msg && msg.length" class="alert alert-info" role="alert">
            {{ msg }}
        </div>
        <div class="container mt-5">
            <div class="row p-2 bg-light border">
                <div class="col-sm-2">
                    #
                </div>
                <div class="col align-items-center justify-content-center">
                    <p>Name</p>
                </div>
                <div class="col align-items-center justify-content-center">
                    <p>Price</p>
                </div>
                <div class="col">
                </div>
                <div class="col">
                </div>
            </div>
            <div v-for="item in searchData" class="row">
                <div class="col-sm-2">
                    <img v-if="getImgPath(item['id']).length > 0" :src="getImgPath(item['id'])"
                         alt="alt" class="img-thumbnail rounded d-block">
                </div>
                <div class="col align-items-center justify-content-center">
                    <p>{{ item['ab_name'] }}</p>
                </div>
                <div class="col align-items-center justify-content-center">
                    <p>{{ item['ab_price'] }}</p>
                </div>
                <!--               <div class="col align-items-center justify-content-center">-->
                <!--                   <a class="nav-link " v-on:click="addToShoppingCart(item['id'])"> Add to shopping cart</a>-->
                <!--               </div>-->
                <div v-if="this.own_articles.includes(item['id'])"
                     class="col align-items-center justify-content-center">
                    <a class="nav-link " v-on:click="articleToPromotion(item['id'])"> Add to promotion</a>
                </div>
            </div>
            <div v-if="totalDataLength >= 5" class="row">
                <div class="col align-items-start">
                    <a v-if="pageCounter >= 0" class="nav-link" v-on:click="this.decrement()">Previous</a>
                </div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col align-items-end">
                    <a v-if="pageCounter <= this.counterMax" class="nav-link" v-on:click="this.increment()">Next</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "articlesearch",
    mounted() {
        this.fetchData(null, this.rows * this.pageCounter)
        this.promoting()
        // this.sendCurrentArticles()
    },
    data() {
        return {
            searchInput: '',
            searchData: [],
            rows: 5,
            pageCounter: 0,
            totalDataLength: 0,
            totalPage: [],
            counterMax: 0,
            msg: ''
        }
    },
    props: {
        own_articles: {
            Array,
            required: true,
        },
        promotionSocket: WebSocket
    },
    watch: {
        searchInput: function () {
            if (this.searchInput.length > 2)
                this.fetchData(this.searchInput, this.rows * this.pageCounter)
            else {
                this.fetchData(null, this.rows * this.pageCounter)
            }
        }
    },
    methods: {
        async fetchData(searchData, offset) {
            let url = ''
            if (searchData === null) {
                url = '/api/articles?offset=' + offset
            } else {
                url = '/api/articles?searchInput=' + searchData + "&offset=" + offset
            }

            const {data} = await axios.get(url)

            if (data) {
                this.searchData = data['data']
                this.totalDataLength = data['data'].length
                this.counterMax = parseInt(data['data_length'] / this.rows) + 2
                for (let i = 0; i < this.searchData.length; i++) {
                    this.totalPage.push(i);
                }
            }

            this.sendCurrentArticles()
        },

        promoting() {
            this.promotionSocket.onopen = (event) => {
                console.log('Connection established');
            }

            this.promotionSocket.onclose = (event) => {
                console.log('Connection closes');
            }

            this.promotionSocket.onmessage = (messageEvent) => {

                let data = JSON.parse(messageEvent['data'])
                let hasArticle = false

                this.searchData.forEach(function (item) {
                    if (item.id === data.id) {
                        hasArticle = true
                    }
                })
                if (hasArticle && data?.name)
                    this.msg = 'Der Artikel ' + data.name.trim() + ' wird nun günstiger Angeboten! Greifen Sie schnell zu!'
                else {
                    this.msg = null
                }
            }

        },

        sendCurrentArticles() {
            const type = 'get_current_promotion'

            let currentIds = []

            this.searchData.forEach(data => currentIds.push(data.id))

            this.promotionSocket.send(JSON.stringify({
                'type': type,
                'id': currentIds,
            }))
        },

        async articleToPromotion(id) {
            let url = '/api/add-to-promotion'
            await axios.post(url, {
                'article_id': id
            })
                .then()
                .catch(error => console.log(error))
        },

        getImgPath: function (id) {
            if (require("/assets/img/" + id + ".jpg"))
                return "assets/img/" + id + ".jpg"
            else if (require("/assets/img/" + id + ".png")) {
                return "assets/img/" + id + ".png"
            } else return ''
        },

        async addToShoppingCart(id) {
            let formData = new FormData();
            formData.append('id', id)
            await axios.post('/api/articles/' + id + '/sold');
        },

        increment: function () {
            this.pageCounter = this.pageCounter++ <= this.counterMax ? this.pageCounter++ : this.pageCounter

            this.fetchData(this.searchInput.length > 2 ? this.searchInput : null, this.rows * this.pageCounter)
        },

        decrement: function () {
            this.pageCounter = this.pageCounter-- >= 0 ? this.pageCounter-- : this.pageCounter
            this.fetchData(this.searchInput.length > 2 ? this.searchInput : null, this.rows * this.pageCounter)
        }
    }
}
</script>

<style scoped>
a:hover {
    cursor: pointer;
}
</style>
