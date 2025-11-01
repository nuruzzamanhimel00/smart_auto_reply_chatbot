import "./bootstrap";
import "../css/app.css";
// import "laravel-datatables-vite";

import { createApp } from "vue";
import VueSweetalert2 from "vue-sweetalert2";
import { ZiggyVue } from "ziggy";
import { i18nVue } from "laravel-vue-i18n";
import { getTrans } from "@/helpers";

import GuestChatBox from "./components/GuestChatBox.vue";
import AdminChatBox from "./components/AdminChatBox.vue";
import AgentChatBox from "./components/AgentChatBox.vue";



const app = createApp({})
    .use(ZiggyVue)
    .use(i18nVue, {
        resolve: async (lang) => {
            const langs = import.meta.glob("../lang/*.json");
            const currentLng = langs[`../lang/${lang}.json`];
            return await currentLng();
        },
    });

// app.config.globalProperties.$t = trans;
app.config.globalProperties.$trans = getTrans;

Object.entries(import.meta.glob("./**/*.vue", { eager: true })).forEach(
    ([path, definition]) => {
        app.component(
            path
                .split("/")
                .pop()
                .replace(/\.\w+$/, ""),
            definition.default
        );
    }
);


app.component("guest-chat-box", GuestChatBox);
app.component("admin-chat-box", AdminChatBox);
app.component("agent-chat-box", AgentChatBox);

app.use(VueSweetalert2);
app.mount("#vueApp");
