<script setup lang="ts">
import {inject, ref} from "vue";
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CustomTable from "@/Components/CustomTable.vue";

const $trans = inject('$trans') as (value: string) => string;

const tableHeaders = ref<Record<string, string>>({
    'user.name': $trans('Name Surname'),
    'description': $trans('Description'),
    'location.name': $trans('Location'),
    'type': $trans('Application Type'),
    'created_at': $trans('Created Date'),
    'actions': '#'
});
</script>

<template>
    <Head :title="$trans('Application List')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $trans('Application List')}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <CustomTable :headers="tableHeaders"  :url="route('application.data')" :raws="['actions']"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
