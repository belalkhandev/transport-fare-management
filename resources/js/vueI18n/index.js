import {createI18n} from "vue-i18n";

import en from './lang/en.json';
import bn from './lang/bn.json';

export default createI18n({
    locale: localStorage.getItem('lang') || 'bn',
    fallbackLocale: 'en',
    messages: {
        en: en,
        bn: bn
    },
    legacy: false
})
