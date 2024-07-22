<template>
    <div class="rocket-overview">
        <h1>Rocket Overview</h1>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "RocketOverview",
    data() {
        return {
            rocket: null,
        };
    },
    mounted() {
        this.fetchRocketData();
    },
    methods: {
        async fetchRocketData() {
            try {
                const response = await axios.get("/api/rocket-overview");
                this.rocket = response.data;
                console.log("fetchRocketData", this.rocket);
            } catch (error) {
                console.error("Error fetching rocket data:", error);
            }
        },
    },
};
</script>

<style scoped>
.rocket-overview {
    padding: 20px;
}
</style>
