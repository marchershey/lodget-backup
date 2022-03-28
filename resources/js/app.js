window._ = require("lodash");
window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Alpine JS
 */
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

/**
 * Formatters / Masks
 * Cleave - https://github.com/nosir/cleave.js
 */
import Cleave from "cleave.js";
import CleaveUSPhone from "cleave.js/dist/addons/cleave-phone.us";
function formatPhone(element) {
    new Cleave(element, {
        phone: true,
        delimiter: " ",
        phoneRegionCode: "US",
    });
}
function formatDate(element) {
    new Cleave(element, {
        date: true,
        delimiter: "/",
        datePattern: ["m", "d", "Y"],
    });
}
function formatZipCode(element) {
    new Cleave(element, {
        numericOnly: true,
        blocks: [5],
        rawValueTrimPrefix: true,
    });
}
function formatMoney(element) {
    new Cleave(element, {
        numeral: true,
        numeralPositiveOnly: true,
        numeralDecimalMark: ".",
        delimiter: ",",
        numeralDecimalScale: 2,
        rawValueTrimPrefix: true,
    });
}
document.querySelectorAll(".phone").forEach((element) => {
    formatPhone(element);
});
document.querySelectorAll(".date").forEach((element) => {
    formatDate(element);
});
document.querySelectorAll(".money").forEach((element) => {
    formatMoney(element);
});
document.querySelectorAll(".zip-code").forEach((element) => {
    formatZipCode(element);
});
window.addEventListener("maskAllElements", (event) => {
    document.querySelectorAll(".phone").forEach((element) => {
        formatPhone(element);
    });
    document.querySelectorAll(".date").forEach((element) => {
        formatDate(element);
    });
    document.querySelectorAll(".money").forEach((element) => {
        formatMoney(element);
    });
    document.querySelectorAll(".zip-code").forEach((element) => {
        formatZipCode(element);
    });
});

/**
 * Calendar
 */

// Litepicker - mini calendar
import Litepicker from "litepicker";
import "litepicker/dist/plugins/mobilefriendly";

// Flatpickr - mini calendar
import flatpickr from "flatpickr";
window.flatpickr = flatpickr;

// FullCalendar.io (v5) - big calendar
// https://fullcalendar.io/
import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import listPlugin from "@fullcalendar/list";
window.Calendar = Calendar;
window.interactionPlugin = interactionPlugin;
window.dayGridPlugin = dayGridPlugin;
window.listPlugin = listPlugin;
window.defaultCalendarOptions = {
    plugins: [interactionPlugin, dayGridPlugin, listPlugin],
    aspectRatio: 2,
    displayEventTime: false,
    displayEventTime: false,
    displayEventEnd: false,
    editable: false,
    headerToolbar: {
        left: "today dayGridMonth,listMonth,resourceTimeGridDay",
        center: "title",
        right: "prev,next",
    },
    buttonText: {
        today: "Today",
        month: "Calendar View",
        list: "List View",
    },
};

/**
 * Draggable - v1.0.0-beta.12
 * https://github.com/Shopify/draggable
 */
import { Sortable, Plugins } from "@shopify/draggable";
window.Sortable = Sortable;
window.Plugins = Plugins;

/**
 * Swiper JS - 8.0.7
 * https://swiperjs.com/get-started
 */
import Swiper from "swiper/bundle";
import "swiper/css/bundle";
window.Swiper = Swiper;

// photo slider - splidejs
import Splide from "@splidejs/splide";
import splideCss from "@splidejs/splide/dist/css/themes/splide-default.min.css";
window.Splide = Splide;
