<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Multiselect from "@vueform/multiselect";

interface TableRow {
    [key: string]: any;
}

interface Pagination {
    prev: string | null;
    next: string | null;
}

const props = withDefaults(defineProps<{
    url:string,
    headers:Record<string, string>,
    raws?:string[] | undefined
}>(),{
    raws: ()=> []
})

const data = ref<TableRow[]>([]);
const search = ref('');
const sortBy = ref('');
const sortDirection = ref('asc');
const loading = ref(true);
const perPage = ref(10);
const pagination = ref<Pagination>({
    prev: null,
    next: null
});

const fetchData = async (url: string | null = null) => {
    loading.value = true;

    try {
        const response = await axios.get(url || props.url, {
            params: {
                search: search.value,
                sortBy: sortBy.value,
                sortDirection: sortDirection.value,
                perPage: perPage.value
            },
        });
        data.value = response.data.data;
        pagination.value = response.data.links;
    } catch (error) {
        console.error('Error fetching data', error);
    } finally {
        loading.value = false;
    }
};

const setSortBy = (header: string) => {
    if (sortBy.value === header) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortBy.value = header;
        sortDirection.value = 'asc';
    }
    fetchData();
};

const getNestedValue = (obj: any, path: string) => {
    return path.split('.').reduce((value, key) => value && value[key], obj);
};

onMounted(() => {
    fetchData();
});

watch([search, sortDirection, perPage], () => {
    fetchData();
});
</script>

<template>
    <div>
        <div class="flex justify-between mb-4">
            <div>
                <TextInput v-model="search" :placeholder="$trans('Search')" />
            </div>
            <div class="w-1/6">
                <Multiselect
                    placeholder="Per Page"
                    :options="[10,20,30]"
                    v-model="perPage"
                />
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th
                        v-for="(label, key) in headers"
                        :key="key"
                        @click="setSortBy(key)"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400 cursor-pointer"
                    >
                        {{ label }}
                        <span v-if="sortBy === key">
                {{ sortDirection === 'asc' ? '↑' : '↓' }}
              </span>
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                <tr v-for="row in data" :key="row.id">
                    <td v-for="key in Object.keys(headers)" :key="key" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                        <div v-if="raws.findIndex(raw => raw == key) > -1" v-html="getNestedValue(row, key)"></div>
                        <div v-else v-text="getNestedValue(row, key)" />
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="mt-4 flex justify-between">
                <PrimaryButton @click="fetchData(pagination.prev)" :disabled="!pagination.prev"> Previous </PrimaryButton>
                <PrimaryButton @click="fetchData(pagination.next)" :disabled="!pagination.next"> Next </PrimaryButton>
            </div>
        </div>
    </div>
</template>



<style scoped>

</style>
