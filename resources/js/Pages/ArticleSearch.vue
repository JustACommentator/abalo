<template>
   <div>
       <div class="container-fluid">
           <label for="search" class="form-label">Search</label>
           <input v-model="searchStatus" type="email" class="form-control" id="search" placeholder="Please enter a article">
       </div>
       <div class="container mt-5" >
           <div class="row p-2 bg-light border">
               <div class="col-sm-2">
                   #
               </div>
               <div class="col align-items-center justify-content-center">
                   <p>Name</p>
               </div>
               <div class="col align-items-center justify-content-center">
                   <p>Preis</p>
               </div>
           </div>
           <div class="row" v-for="item in searchData">
               <div class="col-sm-2">
                   <img v-if="getImgPath(item['id']).length > 0" :src="getImgPath(item['id'])" class="img-thumbnail rounded d-block" alt="alt">
               </div>
               <div class="col align-items-center justify-content-center">
                   <p>{{ item['ab_name'] }}</p>
               </div>
               <div class="col align-items-center justify-content-center">
                   <p>{{ item['ab_price'] }}</p>
               </div>
           </div>
       </div>
   </div>
</template>

<script>

export default {
    mounted(){
        this.fetchData(null)
    },
    data(){
        return {
            searchStatus : '',
            searchData : []
        }
    },
    watch: {
        searchStatus: function (){
            if(this.searchStatus.length > 2)
                this.fetchData(this.searchStatus)
            else {
                this.fetchData(null)
            }
        }
    },
    methods: {
         async fetchData(searchData){
             let url = ''
             if(searchData === null){
                 url = '/api/articles'
             } else {
                 url = '/api/articles?searchInput=' + searchData
             }

             const { data } = await axios.get(url)

             if(data)
                this.searchData = data
        },

        getImgPath : function (id){
             if(require("/assets/img/" + id + ".jpg"))
                return "assets/img/" + id + ".jpg"
             else if( require("/assets/img/" + id + ".png")){
                return "assets/img/" + id + ".png"
             } else return ''
        }
    }
}
</script>

<style scoped>

</style>
