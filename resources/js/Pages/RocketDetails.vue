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
                        {{ selectedRocket?.status }}
                    </p>
                    <p>
                        <strong>Mass:</strong>
                        {{ selectedRocket?.mass }} kg
                    </p>
                    <p>
                        <strong>Altitude:</strong>
                        {{ selectedRocket?.altitude }} m
                    </p>
                    <p>
                        <strong>Speed:</strong>
                        {{ selectedRocket?.speed }} m/s
                    </p>
                    <p>
                        <strong>Acceleration:</strong>
                        {{ selectedRocket?.acceleration }} m/s²
                    </p>
                    <p>
                        <strong>Thrust:</strong>
                        {{ selectedRocket?.thrust }} N
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
                <div class="mt-4">
                    <h3 class="text-lg font-bold">Telemetry</h3>
                    <p>
                        <strong>Host:</strong>
                        {{ selectedRocket?.telemetry?.host }}
                    </p>
                    <p>
                        <strong>Port:</strong>
                        {{ selectedRocket?.telemetry?.port }}
                    </p>
                </div>
                <div class="mt-4" v-if="selectedRocket?.status === 'launched'">
                    <h3 class="text-lg font-bold">Launched At:</h3>
                    <p>
                        {{ formatDate(selectedRocket?.timestamps?.launched) }}
                    </p>
                </div>
                <div class="mt-4 card-actions justify-center space-x-4">
                    <button
                        class="btn btn-wide btn-neutral"
                        @click="updateStatus(selectedRocket?.id, 'deployed')"
                    >
                        Deploy
                    </button>
                    <button
                        class="btn btn-wide btn-outline"
                        @click="updateStatus(selectedRocket?.id, 'launched')"
                    >
                        Launch
                    </button>
                    <button
                        class="btn btn-wide btn-outline"
                        @click="cancelRocket(selectedRocket?.id)"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { formatDate } from "@/Utils/dateUtils.js";
import axios from "axios";

const props = defineProps({
    selectedRocket: Object,
});
const updateStatus = async (rocketId, status) => {
    try {
        await axios.put(`/api/rocket/${rocketId}/status/launched`);
        alert(`Rocket ${rocketId} ${status} successfully!`);
    } catch (error) {
        console.error("Error", error);
        alert("Failed to update the status.");
    }
};
const cancelRocket = async (rocketId) => {
    try {
        await axios.delete(`/api/rocket/${rocketId}/status/launched`);
        alert(`Rocket ${rocketId} cancelled successfully!`);
    } catch (error) {
        console.error("Error cancelling rocket:", error);
        alert("Failed to cancel the rocket.");
    }
};
</script>
