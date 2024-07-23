<template>
    <div class="card bg-white shadow-md rounded-lg p-4 text-right">
        <h3 class="text-gray-600 text-lg mb-4">{{ title }}</h3>
        <div v-if="type === 'weather'" class="flex flex-col">
            <div class="text-gray-800 text-4xl font-bold mb-2 text-white">
                {{ value }}
            </div>
            <div class="text-gray-600 text-sm">
                <p>{{ description }}</p>
            </div>
        </div>
        <div v-else-if="type === 'pressure'">
            <div class="text-white text-3xl font-bold mb-2">{{ value }}</div>
            <div class="relative h-2 bg-gray-200 rounded-full">
                <div
                    class="absolute top-0 left-0 h-full bg-blue-500 rounded-full"
                    style="width: 30%"
                ></div>
                <div
                    class="absolute top-0 left-1/2 h-full bg-green-500 rounded-full"
                    style="width: 10%"
                ></div>
                <div
                    class="absolute top-0 right-0 h-full bg-red-500 rounded-full"
                    style="width: 30%"
                ></div>
            </div>
            <div class="flex justify-between text-xs text-gray-600 mt-2">
                <span>Low</span>
                <span>High</span>
            </div>
        </div>

        <div v-else-if="type === 'wind'" class="flex flex-col items-center">
            <div class="text-white text-3xl font-bold mb-2">
                {{ value }}
            </div>

            <div class="relative w-32 h-32 mb-4">
                <div
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full border border-gray-300 rounded-full"
                >
                    <div
                        class="absolute inset-0 flex items-center justify-center"
                    >
                        <svg
                            class="arrow-icon"
                            :style="{
                                transform: `rotate(${angle}deg)`,
                            }"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="white"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M12 2L12 22M12 22L5 15M12 22L19 15" />
                        </svg>
                    </div>
                </div>
                <div
                    class="absolute top-0 left-1/2 transform -translate-x-1/2 text-gray-800 text-xs py-1"
                >
                    N
                </div>
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 text-gray-800 text-xs py-1"
                >
                    S
                </div>
                <div
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 text-gray-800 text-xs py-1"
                >
                    W
                </div>
                <div
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 text-gray-800 text-xs py-1"
                >
                    E
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true,
        },
        value: {
            type: String,
            required: true,
        },
        description: {
            type: String,
            required: false,
            default: "",
        },
        type: {
            type: String,
            required: true,
        },
        direction: {
            type: String,
            required: false,
            default: "",
        },
        angle: {
            type: Number,
            required: false,
            default: 0,
        },
    },
};
</script>

<style scoped>
.arrow-icon {
    width: 24px;
    height: 24px;
    position: absolute;
    bottom: 50%;
    transform: translateY(50%);
}
</style>
