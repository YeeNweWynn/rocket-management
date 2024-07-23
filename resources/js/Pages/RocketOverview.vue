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
                        <button class="btn btn-ghost btn-sm">Launched</button>
                        <button class="btn btn-natural btn-sm">
                            Preparing to Launch
                        </button>
                    </div>
                    <div class="slide-menu flex overflow-x-scroll space-x-4">
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
                            @click="selectRocket(rocket.id)"
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

                <div
                    class="rocket-details mt-6 bg-white rounded-lg shadow-lg p-6"
                >
                    <div
                        class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6"
                    >
                        <div class="card shadow-lg rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <h2 class="text-xl font-bold">Name</h2>
                            </div>
                            <div>
                                <p><strong>ID:</strong> 123</p>
                                <p><strong>Status:</strong> Ready to launch</p>
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-bold">Payload</h3>
                                <p>
                                    <strong>Description:</strong> Apollo CSM-109
                                    Odyssey, Apollo LM-7 Aquarius, 3 Astronauts
                                </p>
                                <p><strong>Weight:</strong> 1542 kg</p>
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-bold">Telemetry</h3>
                                <p><strong>Host:</strong> 0.0.0.0</p>
                                <p><strong>Port:</strong> 4000</p>
                            </div>
                            <div
                                class="mt-4 card-actions justify-center space-x-4"
                            >
                                <button class="btn btn-wide btn-neutral">
                                    Deploy
                                </button>
                                <button class="btn btn-wide btn-outline">
                                    Launch
                                </button>
                                <button class="btn btn-wide btn-outline">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Weather />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import Weather from "@/Components/Weather.vue";

const rockets = ref([]);
const selectedRocketId = ref(null);

const fetchRocketData = async () => {
    try {
        const response = await axios.get("/api/rocket-overview");
        rockets.value = response.data;
        if (rockets.value.length > 0) {
            selectedRocketId.value = rockets.value[0].id;
        }
        console.log("fetchRocketData", this.rocket);
    } catch (error) {
        console.error("Error fetching rocket data:", error);
    }
};

const launchRocket = async (rocketId) => {
    try {
        await axios.put(`/api/rocket/${rocketId}/status/launched`);
        alert(`Rocket ${rocketId} launched successfully!`);
    } catch (error) {
        console.error("Error launching rocket:", error);
        alert("Failed to launch the rocket.");
    }
};
const selectRocket = (rocketId) => {
    selectedRocketId.value = rocketId;
};

const getStatusClass = (status) => {
    return status === "launched"
        ? "btn btn-xs btn-success"
        : "btn btn-xs btn-info";
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
