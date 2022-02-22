window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Alpine JS 
 */
import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()


/**
 * Formatters / Masks
 */
// Cleave - https://github.com/nosir/cleave.js
import Cleave from 'cleave.js'
document.querySelectorAll('.money').forEach(element => {
    new Cleave(element, {
        numeral: true,
        numeralPositiveOnly: true,
        numeralDecimalMark: '.',
        delimiter: ',',
        numeralDecimalScale: 2
    });
});
window.addEventListener('maskDollar', event => {
    document.querySelectorAll('.money').forEach(element => {
        new Cleave(element, {
            numeral: true,
            numeralPositiveOnly: true,
            numeralDecimalMark: '.',
            delimiter: ',',
            numeralDecimalScale: 2
        });
    });
})