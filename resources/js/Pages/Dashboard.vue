<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Sidebar from "@/Components/Sidebar.vue";
import RocketOverview from "./RocketOverview.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="flex">
            <Sidebar class="w-1/6" />
            <div class="flex-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <RocketOverview />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
