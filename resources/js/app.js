


require('./bootstrap');

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import { createApp} from "vue";
// import ArticleSearch from "./Pages/ArticleSearch";
// import siteheader from "./Components/siteheader";
// import sitebody from "./Components/sitebody";
// import sitefooter from "./Components/sitefooter";
import newsite from "./Pages/newsite";


const app = createApp({})
//
// app.component('article-search', ArticleSearch)
// app.component('site-header', siteheader)
// app.component('site-body', sitebody)
// app.component('site-footer', sitefooter)
app.component('newsite', newsite)
app.mount('#app')
