require("./bootstrap");

// import Vue
import Vue from "vue";
import App from "./vue/app.vue";
import Home from "./vue/home.vue";

import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faPlusSquare,
    faTrash,
    faEnvelope,
    faLock,
    faArrowCircleRight,
    faCartPlus,
    faBan,
    faToggleOn,
    faPencilSquare,
    faWindowClose,
} from "@fortawesome/free-solid-svg-icons";

library.add(
    faPlusSquare,
    faTrash,
    faEnvelope,
    faLock,
    faArrowCircleRight,
    faCartPlus,
    faBan,
    faToggleOn,
    faPencilSquare,
    faWindowClose
);
Vue.component("font-awesome-icon", FontAwesomeIcon);

const app = new Vue({
    el: "#app",
    components: { App, Home },
});
