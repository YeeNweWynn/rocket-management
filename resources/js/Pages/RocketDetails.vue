<template>
    <div class="rocket-details mt-6 bg-white rounded-lg shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
            <div class="card shadow-lg rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <h2 class="text-xl font-bold">
                        {{ selectedRocket?.model }}
                    </h2>
                </div>
                <div>
                    <p>
                        <strong>ID:</strong>
                        {{ selectedRocket?.id }}
                    </p>
                    <p>
                        <strong>Status:</strong>
                        {{ formatName(selectedRocket?.status) }}
                    </p>
                    <p>
                        <strong>Mass:</strong>
                        {{ selectedRocket?.mass }} kg
                    </p>
                    <p>
                        <strong>Altitude:</strong>
                        {{ selectedRocket?.altitude?.toFixed(2) }} m
                    </p>
                    <p>
                        <strong>Speed:</strong>
                        {{ selectedRocket?.speed?.toFixed(2) }} m/s
                    </p>
                    <p>
                        <strong>Acceleration:</strong>
                        {{ selectedRocket?.acceleration?.toFixed(2) }} m/s²
                    </p>
                    <p>
                        <strong>Thrust:</strong>
                        {{ selectedRocket?.thrust?.toFixed(2) }} N
                    </p>
                    <p>
                        <strong>Temperature:</strong>
                        {{ selectedRocket?.temperature }} °C
                    </p>
                </div>
                <div class="mt-4">
                    <h3 class="text-lg font-bold">Payload</h3>
                    <p>
                        <strong>Description:</strong>
                        {{ selectedRocket?.payload?.description }}
                    </p>
                    <p>
                        <strong>Weight:</strong>
                        {{ selectedRocket?.payload?.weight }} kg
                    </p>
                </div>
                <div class="mt-4" v-if="selectedRocket?.status !== 'waiting'">
                    <h3 class="text-lg font-bold">
                        {{ formatName(selectedRocket?.status) }} At:
                    </h3>
                    <p>
                        {{
                            formatDateTime(selectedRocket?.timestamps?.launched)
                        }}
                    </p>
                </div>
                <div class="mt-4 card-actions justify-center space-x-4">
                    <button
                        class="btn btn-wide btn-neutral"
                        :disabled="
                            isLaunching ||
                            selectedRocket?.status === 'launched' ||
                            selectedRocket?.status === 'deployed'
                        "
                        :loading="isLaunching"
                        @click="handleUpdateStatus('launched')"
                    >
                        Launch
                    </button>
                    <button
                        class="btn btn-wide btn-neutral"
                        :disabled="
                            (!isLaunched &&
                                selectedRocket?.status !== 'launched') ||
                            isDeploying
                        "
                        :loading="isDeploying"
                        @click="handleUpdateStatus('deployed')"
                    >
                        Deploy
                    </button>
                    <button
                        class="btn btn-wide btn-outline"
                        @click="handleCancelRocket()"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onUnmounted } from "vue";
import { formatDateTime, formatName } from "@/Utils/dateUtils.js";
import axios from "axios";

const props = defineProps({
    selectedRocket: Object,
});

const isLaunching = ref(false);
const isDeploying = ref(false);
const isLaunched = ref(false);
const pollingInterval = ref(null);

const updateStatus = async (status) => {
    if (status === "launched") {
        isLaunching.value = true;
    } else if (status === "deployed") {
        isDeploying.value = true;
    }

    try {
        await axios.put(
            `/api/rocket/${props.selectedRocket.id}/status/launched`
        );
        alert(`Rocket ${props.selectedRocket.id} ${status} successfully!`);
        if (status === "launched") {
            isLaunched.value = true;
        }
    } catch (error) {
        console.error("Error", error);
        alert(`Failed to ${status} the rocket.`);
    } finally {
        if (status === "launched") {
            isLaunching.value = false;
        } else if (status === "deployed") {
            isDeploying.value = false;
        }
    }
};

const cancelRocket = async (status) => {
    try {
        await axios.delete(
            `/api/rocket/${props.selectedRocket.id}/status/launched`
        );
        alert(`Rocket ${props.selectedRocket.id} cancelled successfully!`);
    } catch (error) {
        console.error("Error", error);
        alert("Failed to cancel the rocket.");
    }
};

const fetchRocketData = async () => {
    try {
        const response = await axios.get(`/api/rocket-overview`);
        const rockets = response.data;

        const selectedRocketData = rockets.find(
            (rocket) => rocket.id === props.selectedRocket.id
        );
        console.log("selectedRocketData", selectedRocketData);
        if (selectedRocketData) {
            Object.assign(props.selectedRocket, selectedRocketData);
        }
    } catch (error) {
        console.error("Error fetching latest rocket data:", error);
    }
};

const handleUpdateStatus = async (status) => {
    await updateStatus(status);
    await fetchRocketData();
};

const handleCancelRocket = async () => {
    await cancelRocket();
    await fetchRocketData();
};

onUnmounted(() => {
    clearInterval(pollingInterval.value);
});
</script>
