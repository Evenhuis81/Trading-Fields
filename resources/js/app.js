/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

import VueChatScroll from "vue-chat-scroll";
Vue.use(VueChatScroll);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("chats", require("./components/ChatsComponent.vue").default);

import Axios from "axios";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});

// maak voor iedere pagina een eigen aparte javascript file en include deze alleen voor de desbetreffende pagina voor betere
// projectorganisatie van bestanden en betere leesbaarheid / lagere laadtijd / makkelijker debuggen van code

// Index page
import * as index from "./index.js";
import * as pay from "./pay.js";
import * as admanindex from "./admanindex";
import * as login from "./login.js";
import * as create from "./create.js";
import * as edit from "./edit.js";
import * as searchbar from "./searchbar.js";
// import * as show from "./show.js";

$(document).ready(function() {
    // Main Index Page
    index.closeCookie();
    index.selectCats();
    index.allCat();

    // Manage Adverts Page
    admanindex.toggle();
    admanindex.deletead();

    // Payment Page
    pay.stripe();

    // Login Page
    login.showpass();

    // Create Advert Page
    create.bidcheck();
    create.bidchange();
    create.filechange();

    // Edit Advert
    edit.titlehover();

    // Searchbar
    searchbar.inputQuery();
    searchbar.selectQuery();
    searchbar.searchListOn();
    searchbar.searchListOff();
    searchbar.escapePressed();
});

// Main Index Page
index.paginate();

// Show page
// show.postBid();
// show.deleteBid();
// show.visitorBid();
