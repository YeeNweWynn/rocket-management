<template>
    <div
        class="weather-container w-1/5 mt-4 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg shadow-lg p-6 mb-4"
    >
        <div class="text-white text-base font-bold">Weather</div>

        <div class="text-white text-xs">{{ location }} , {{ todayDate }}</div>
        <div
            class="bg-white/20 rounded-xl p-4 mt-4 text-right backdrop-blur-md"
        >
            <div class="text-white text-3xl font-bold">
                {{ temperatureData }} /
                <span class="text-xl font-normal"> 25°C</span>
            </div>
            <div class="text-white text-sm">Cloudy</div>
            <div class="text-gray-600 text-sm">
                Great time to launch rocket.
            </div>
        </div>
        <div class="flex flex-col gap-4 mt-4">
            <WeatherCard
                v-if="weatherTimes.humidity"
                title="Humidity"
                :value="humidityData"
                description="The dew point is 24°C."
                type="weather"
            />
            <WeatherCard
                v-if="weatherTimes.pressure"
                title="Pressure"
                :value="pressureData"
                type="pressure"
            />
            <WeatherCard
                v-if="weatherTimes.precipitation"
                title="Precipitation"
                :value="precipitationData"
                :description="precipitationDescription"
                type="weather"
            />
            <WeatherCard
                v-if="weatherTimes.wind"
                title="Wind"
                :value="windData"
                :direction="weatherTimes.wind.direction"
                :angle="windAngel"
                type="wind"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import WeatherCard from "@/Components/WeatherCard.vue";

const weatherTimes = ref({});

const location = "Bangkok, Thailand";

const fetchWeatherData = async () => {
    try {
        const response = await axios.get("/api/weather");
        console.log("Weather data:", response.data);
        weatherTimes.value = response.data;
        console.log("fetchWeatherData", weatherTimes.value.temperature);
    } catch (error) {
        console.error("Error fetching weather data:", error);
    }
};

onMounted(() => {
    fetchWeatherData();
});
const todayDate = computed(() => {
    return new Date().toLocaleDateString("en-US", {
        day: "numeric",
        month: "short",
        year: "numeric",
    });
});

const temperatureData = computed(() => {
    return weatherTimes.value.temperature
        ? `${weatherTimes.value.temperature.toFixed(1)}°C`
        : "N/A";
});
const humidityData = computed(() => {
    return weatherTimes.value.humidity !== undefined
        ? `${(weatherTimes.value.humidity * 100).toFixed(0)}%`
        : "N/A";
});
const pressureData = computed(() => {
    return weatherTimes.value.pressure !== undefined
        ? `${weatherTimes.value.pressure.toFixed(0)} hPa`
        : "N/A";
});
const windData = computed(() => {
    return weatherTimes.value.wind?.speed !== undefined
        ? `${weatherTimes.value.wind.speed.toFixed(1)} km/h`
        : "N/A";
});
const precipitationData = computed(() => {
    return weatherTimes.value.precipitation?.probability !== undefined
        ? `${(weatherTimes.value.precipitation.probability * 100).toFixed(0)}%`
        : "N/A";
});
const precipitationDescription = computed(() => {
    if (!weatherTimes.value.precipitation)
        return "No precipitation data available.";

    const types = [];
    if (weatherTimes.value.precipitation.rain) types.push("rain");
    if (weatherTimes.value.precipitation.snow) types.push("snow");
    if (weatherTimes.value.precipitation.sleet) types.push("sleet");
    if (weatherTimes.value.precipitation.hail) types.push("hail");

    return types.length
        ? `Expected: ${types.join(" and ")}.`
        : "No precipitation expected.";
});
const windAngel = computed(() => {
    return weatherTimes.value.wind?.angle !== undefined
        ? `${weatherTimes.value.wind.angle.toFixed(0)}`
        : 0;
});
</script>

<style scoped>
.weather-container {
    max-width: 300px; /* Adjust as needed */
}
.card {
    background: rgba(255, 255, 255, 0.3); /* Semi-transparent white */
    backdrop-filter: blur(10px); /* Blur effect for background */
}
</style>
