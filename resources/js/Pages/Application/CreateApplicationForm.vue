<script setup lang="ts">
import {Head, useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import LocationSelect from "@/Components/LocationSelect.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Multiselect from "@vueform/multiselect";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps<{
    types:{
        title:string;
        name:string;
        value:string;
    }[]
}>()

const user = usePage().props.auth.user

const form = useForm({
    name: user?.name || '',
    email: user?.email || '',
    phone: '',
    location_id:null,
    description: '',
    type:''
})

const submit = () => {
    form.post(route('application.store'),{
        preserveScroll: true,
        onSuccess: () => form.reset(),
    })
}

</script>

<template>
    <Head :title="$trans('Create Application Form')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $trans('Create Application Form')}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit" class="flex flex-col gap-3">
                            <div>
                                <InputLabel for="name" :value="$trans('Name Surname')" />
                                <TextInput id="name" class="w-full" v-model="form.name" :disabled="user" />
                            </div>
                            <div>
                                <InputLabel for="email" :value="$trans('E-Mail')" />
                                <TextInput id="email" class="w-full" v-model="form.email" :disabled="user" />
                            </div>
                            <div>
                                <InputLabel for="phone" :value="$trans('Phone')" />
                                <TextInput id="phone" class="w-full" v-model="form.phone" :disabled="user" />
                            </div>
                            <LocationSelect v-model="form.location_id" />
                            <div>
                                <InputLabel for="type" :value="$trans('Application Type')" />
                                <Multiselect :options="types" v-model="form.type" label="title" value-prop="value" :placeholder="$trans('Application Type')" required />
                                <InputError :message="form.errors.type" />
                            </div>
                            <div>
                                <InputLabel for="description" :value="$trans('Application Description')" />
                                <TextAreaInput id="description" class="w-full" v-model="form.description" rows="8" required />
                                <InputError :message="form.errors.description" />
                            </div>

                            <div>
                                <PrimaryButton :disabled="form.processing" type="submit">{{ $trans('Submit') }}</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
