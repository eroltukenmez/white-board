<script setup lang="ts">
import { ComputerDesktopIcon, DevicePhoneMobileIcon } from '@heroicons/vue/24/solid'
import DangerButton from "@/Components/DangerButton.vue";
import {useForm} from "@inertiajs/vue3";

defineProps<{
    sessions:{
        id:string;
        ip_address:string;
        user_agent:string;
        last_activity:number;
    }[]
}>()

const form = useForm({
    id:''
})

const revoke = (id:string) => {
    form.id = id
    form.post(route('revoke'),{
        preserveScroll:true,
        onError: () => {
            console.log(form.errors)
        }
    })
}
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Active Sessions</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                All sessions and devices
            </p>
        </header>

        <div  class="">
            <ol class="rounded-lg drop-shadow-lg">
                <li class="relative border-b border-gray-400 last:border-0" v-for="session in sessions" >
                    <div class="flex w-full items-center gap-5 py-2">
                        <div class="w-9 h-9 p-1 flex-none">
                            <DevicePhoneMobileIcon v-if="session.user_agent.includes('Mobile')" class="text-gray-300"/>
                            <ComputerDesktopIcon v-else class="text-gray-300"/>
                        </div>
                        <div class="w-full">
                            <p class="text-gray-300">{{ session.ip_address }} - <span class="text-gray-200">{{ (new Date(session.last_activity * 1000)).toLocaleString() }}</span></p>
                            <p class="text-gray-400">{{ /\((.*);/gm.exec(session.user_agent)?.pop() }}</p>
                        </div>
                        <div>
                            <DangerButton :disabled="form.processing" @click="revoke(session.id)">Revoke</DangerButton>
                        </div>
                    </div>
                </li>
            </ol>
        </div>

    </section>
</template>
