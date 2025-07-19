<script setup lang="ts">
    import { RouterLink } from 'vue-router'
</script>

<template>
    <div class="header">
        <header class="py-5">
            <RouterLink 
                to="/register" 
                class="rounded-full bg-primaryColor hover:bg-black p-3 text-black hover:text-white border border-black">
                Demonstração
            </RouterLink>
        </header>
    </div>
</template>