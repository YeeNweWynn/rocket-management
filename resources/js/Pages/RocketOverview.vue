<template>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold p-4">
            Rocket Management
            <p class="text-neutral-400 text-xs font-normal">
                Monitor all rockets here.
            </p>
        </h1>

        <div class="flex justify-between">
            <div class="rocket-overview w-4/5">
                <div
                    class="rocket-slider bg-white rounded-lg shadow-lg p-6 mb-4"
                >
                    <div class="flex mb-4 space-x-4">
                        <p class="text-neutral-400 text-xs font-normal">
                            All rockets
                        </p>
                    </div>
                    <LoadingIndicator :isLoading="loading" />

                    <div
                        class="slide-menu flex overflow-x-scroll space-x-4"
                        v-if="!loading"
                    >
                        <div
                            v-for="rocket in rockets"
                            :key="rocket.id"
                            :class="[
                                'rocket-card',
                                {
                                    'bg-base-100':
                                        rocket.id !== selectedRocketId,
                                    'bg-selected':
                                        rocket.id === selectedRocketId,
                                },
                            ]"
                            @click="selectRocket(rocket)"
                        >
                            <h2 class="text-base font-bold mt-4">
                                {{ rocket.model }}
                            </h2>

                            <button :class="getStatusClass(rocket.status)">
                                {{ rocket.status }}
                            </button>
                        </div>
                    </div>
                </div>
                <RocketDetails
                    v-if="selectedRocket"
                    :selectedRocket="selectedRocket"
                />
            </div>
            <Weather />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import LoadingIndicator from "@/Components/LoadingIndicator.vue";
import Weather from "@/Components/Weather.vue";
import RocketDetails from "@/Pages/RocketDetails.vue";

const rockets = ref([]);
const selectedRocketId = ref(null);
const selectedRocket = ref(null);
const loading = ref(false);

const fetchRocketData = async () => {
    try {
        loading.value = true;
        const response = await axios.get("/api/rocket-overview");
        rockets.value = response.data;
        if (rockets.value.length > 0) {
            selectRocket(rockets.value[0]);
            selectedRocketId.value = rockets.value[0].id;
        }
        loading.value = false;
    } catch (error) {
        console.error("Error fetching rocket data:", error);
    }
};
const selectRocket = (rocket) => {
    selectedRocket.value = rocket;
    selectedRocketId.value = rocket.id;
};

const getStatusClass = (status) => {
    if (status === "launched") {
        return "btn btn-xs btn-success mt-4";
    } else if (status === "cancelled") {
        return "btn btn-xs btn-error mt-4";
    } else {
        return "btn btn-xs btn-info mt-4";
    }
};
onMounted(() => {
    fetchRocketData();
});
</script>

<style scoped>
.rocket-overview {
    padding: 20px;
}

.card {
    max-width: 100%;
    margin: auto;
}

.card-actions .btn {
    margin: 4px;
}

.rocket-card {
    border-radius: 0.75rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 1rem;
    min-width: 10rem;
    min-height: 5rem;
}
.bg-selected {
    background-color: #2d3748;
    color: white;
}
.bg-base-100 {
    background-color: #ecf3f6;
}
</style>
