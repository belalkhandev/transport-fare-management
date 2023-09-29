<script setup>
import { useI18n } from "vue-i18n";
const { locale, t} = useI18n()

const changeLanguage = (newLocale) => {
    locale.value = newLocale
    localStorage.setItem('lang', newLocale)
}

</script>

<template>
    <div class="langs">
        <ul class="d-flex justify-items-start align-items-center">
            <li><span @click="changeLanguage('en')">EN</span></li>
            <li><span @click="changeLanguage('bn')">বাং</span></li>
        </ul>
    </div>

</template>
