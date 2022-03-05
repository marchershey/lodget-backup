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
 */
// Cleave - https://github.com/nosir/cleave.js
import Cleave from "cleave.js";
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
document.querySelectorAll(".money").forEach((element) => {
    formatMoney(element);
});
document.querySelectorAll(".zip-code").forEach((element) => {
    formatZipCode(element);
});
window.addEventListener("maskAllElements", (event) => {
    document.querySelectorAll(".money").forEach((element) => {
        formatMoney(element);
    });
    document.querySelectorAll(".zip-code").forEach((element) => {
        formatZipCode(element);
    });
});

/**
 * Calendar
 * FullCalendar.io - v5
 * https://fullcalendar.io/
 */
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
// window.InitSortable = () => {
//     const containers = document.querySelectorAll(".sortable");

//     if (containers.length === 0) {
//         return false;
//     }

//     const sortable = new Sortable(containers, {
//         draggable: ".sortable-item",
//         mirror: {
//             constrainDimensions: true,
//         },
//         plugins: [Plugins.SortAnimation],
//         swapAnimation: {
//             duration: 200,
//             easingFunction: "ease-in-out",
//         },
//     });

//     return sortable;
// };

// import { Sortable, Plugins } from "@shopify/draggable";

// window.InitDraggable = () => {
//     const containers = document.querySelectorAll(".draggable");

//     if (containers.length === 0) {
//         return false;
//     }

//     const sortable = new Sortable(containers, {
//         draggable: ".draggable-item",
//         mirror: {
//             constrainDimensions: true,
//         },
//         plugins: [Plugins.SortAnimation],
//         swapAnimation: {
//             duration: 200,
//             easingFunction: "ease-in-out",
//         },
//     });

//     return sortable;
// };

// draggable.on("drag:start", () => console.log("drag:start"));
// draggable.on("drag:move", () => console.log("drag:move"));
// draggable.on("drag:stop", () => console.log("drag:stop"));
