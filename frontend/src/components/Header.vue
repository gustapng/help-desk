<script setup lang="ts">

</script>

<template>
    <div class="header">
        <header class="flex justify-between items-center">
            <h1>Help Desk</h1>
            <nav class="space-x-4">
                <RouterLink 
                    to="/register" 
                    class="rounded-full bg-primaryColor hover:bg-black p-3 text-black hover:text-white border border-black inline-block">
                    Registre se
                </RouterLink>
                <RouterLink 
                    to="/login" 
                    class="rounded-full bg-colorGreen hover:bg-black p-3 text-black hover:text-white border-colorGreen hover:border-black inline-block">
                    Login
                </RouterLink>
            </nav>
        </header>
    </div>
</template>