<template>
    <div class="sidebar">
        <ul class="menu">
            <li class="menu-item" v-for="item in menuItems" :key="item.name">
                <a :href="item.link">{{ item.name }}</a>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Sidebar",
    data() {
        return {
            menuItems: [
                { name: "Rocket", link: "/dashboard" },
                { name: "Settings", link: "/settings" },
            ],
        };
    },
};
</script>

<style scoped>
.sidebar {
    background-color: #2d3748;
    color: white;
    padding: 1rem;
    margin-bottom: 20px;
}

.menu {
    list-style: none;
    padding: 0;
}

.menu-item {
    margin: 1rem 0;
}

.menu-item a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

.menu-item a:hover {
    text-decoration: underline;
}
</style>
