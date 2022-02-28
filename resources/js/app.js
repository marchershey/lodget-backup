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
// import timeGridPlugin from "@fullcalendar/timegrid";
// import resourceTimelinePlugin from "@fullcalendar/resource-timeline";
// import resourceTimeGridPlugin from "@fullcalendar/resource-timegrid";
window.Calendar = Calendar;
window.interactionPlugin = interactionPlugin;
window.dayGridPlugin = dayGridPlugin;
window.listPlugin = listPlugin;
// window.timeGridPlugin = timeGridPlugin;
// window.resourceTimelinePlugin = resourceTimelinePlugin;
// window.resourceTimeGridPlugin = resourceTimeGridPlugin;
window.defaultCalendarOptions = {
    // schedulerLicenseKey: "GPL-My-Project-Is-Open-Source",
    plugins: [
        interactionPlugin,
        dayGridPlugin,
        listPlugin,
        // resourceTimelinePlugin,
        // resourceTimeGridPlugin,
    ],
    aspectRatio: 2,
    // initialView: "dayGridMonth",
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
