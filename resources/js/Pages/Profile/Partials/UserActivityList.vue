<script setup lang="ts">
import { UserIcon,CogIcon,EllipsisHorizontalIcon, ArrowLeftEndOnRectangleIcon,ArrowRightStartOnRectangleIcon } from '@heroicons/vue/24/solid'

defineProps<{
    activities:{
        event:string;
        causer_type:string;
        description:string;
        properties:{old:object,attributes:object};
        action_time:string;
        created_at_format:string;
    }[]
}>()

</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Account Activities</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                User latest 10 logs and activities.
            </p>
        </header>

        <div  class="">
            <ol class="rounded-lg drop-shadow-lg">
                <li class="relative cursor-pointer" v-for="activity in activities" >
                    <div class="flex flex-col items-start">
                        <div class="flex items-center space-x-2">
                            <div class="w-9 h-9 relative flex-none bg-gray-100 rounded-full">
                                <div class="w-5 h-5 absolute -bottom-1 -right-1 flex justify-center items-center rounded-full bg-white" v-if="activity.event == 'auth'">
                                    <component :is="activity.description == 'logged in' ? ArrowLeftEndOnRectangleIcon : ArrowRightStartOnRectangleIcon"  class="w-4 h-4"/>
                                </div>
                                <UserIcon :class="[activity.description == 'logged in' ? 'text-green-700' : 'text-rose-700',' w-full h-full p-1']" v-if="activity.event == 'auth'" />
                                <CogIcon :class="[activity.event == 'updated' ? 'text-cyan-700' : (activity.event == 'created' ? 'text-green-700' : 'text-red-700') ]" v-else />
                            </div>
                            <div class="flex flex-start justify-center flex-col">
                                <h4 class="text-gray-300 text-lg font-semibold -mb-1 capitalize"> {{ activity.causer_type + ' was ' + activity.description }} </h4>
                                <p class="text-gray-500 text-xs">{{ activity.action_time }} ({{ activity.created_at_format }}) </p>
                                <p class="text-gray-400 text-sm">{{ activity.properties.attributes }}</p>
                            </div>
                        </div>
                        <div class="flex item-start space-x-2">
                            <div class="w-9 py-1 flex justify-center flex-none">
                                <div class="bg-gray-200 w-0.5 h-full rounded-full"></div>
                            </div>
                            <div class="text-sm text-gray-500 mt-1 pb-6"></div>
                        </div>
                        <div class="absolute w-[calc(100%+8px)] h-[calc(100%-6px)] -left-2 -top-2 rounded-lg -z-10"></div>
                    </div>
                </li>
                <li class="relative cursor-pointer group">
                    <div class="flex flex-col items-start">
                        <div class="flex items-center space-x-2 ease-in-out duration-200 will-change-transform group-hover:scale-[1.01]">
                            <div class="w-9 h-9 flex justify-center items-center flex-none bg-gray-100 rounded-full overflow-hidden">
                                <EllipsisHorizontalIcon class="text-gray-700 w-7 h-7" />
                            </div>
                            <div class="flex flex-start justify-center flex-col">
                                <h4 class="text-gray-300 font-semibold text-lg -mb-1">Get More</h4>
                                <p class="text-gray-500 text-sm">Click Here</p>
                            </div>
                        </div>
                        <div class="absolute w-[calc(100%+8px)] h-[calc(100%+16px)] -left-2 -top-2 rounded-lg -z-10 ease-in-out duration-200 will-change-transform group-hover:scale-[1.01] group-hover:bg-gray-600"></div>
                    </div>
                </li>
            </ol>
        </div>

    </section>
</template>
