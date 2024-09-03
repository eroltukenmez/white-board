<script setup lang="ts">
import { onMounted, ref } from "vue";
import { Location } from "@/types";
import Multiselect from "@vueform/multiselect";
import InputLabel from "@/Components/InputLabel.vue";
import axios, { AxiosResponse } from "axios";

const props = withDefaults(
    defineProps<{
        locations?:Location[] | undefined
        title?: string
    }>(),
    {
        title: ''
    }
);

const selected = defineModel<number | null>({ required: false });

const emits = defineEmits<{
    (e: 'update:modelValue', value: number): void
}>();

const active = ref<Location | null>(null);
const childSelect = ref<Location[] | null>(null);
const locations = ref<Location[]>([]);

const onChangeDefault = async () => {
    const ids = [];

    const response: AxiosResponse<{ data: Location }> = await axios.get(route('locations'), {
        params: {id:selected.value}
    });
    let location:Location | undefined = response.data.data

    while (location) {
        ids.unshift(location.id);
        location = location.parent;
    }

}


const fetchInitialLocations = async () => {
    const response: AxiosResponse<{ data: Location[] }> = await axios.get(route('locations'));
    locations.value = response.data.data;

    if (selected.value)
        await onChangeDefault()
};

const fetchLocations = async (id: number) => {
    childSelect.value = null;
    active.value = null;

    const response: AxiosResponse<{ data: Location[] }> = await axios.get(route('locations'), {
        params: (typeof id != "undefined" ? { parent_id: id } : null)
    });

    childSelect.value = response.data.data;

    active.value = locations.value.find(location => location.id == id) || null;

    emits('update:modelValue', id);
};

onMounted(() => {
    if (props.locations === undefined){
        fetchInitialLocations();
    }else{
        locations.value = props.locations
    }
});
</script>

<template>
    <div>
        <InputLabel :value="title + $trans('Location')" />
        <Multiselect :options="locations" label="name" value-prop="id" :placeholder="$trans('Location')" @change="fetchLocations" />
    </div>
    <LocationSelect
        v-if="childSelect && childSelect.length"
        :title="active?.name + ' '"
        v-model="selected"
        :locations="childSelect"
    />
</template>
