<script setup lang="ts">
import {onMounted, ref} from "vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Application} from "@/types";
import { PlusIcon } from '@heroicons/vue/24/solid'
import InputLabel from "@/Components/InputLabel.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Multiselect from "@vueform/multiselect";
import Modal from "@/Components/Modal.vue";
import Assignment from "@/Pages/Application/Modals/Assignment.vue";

const props = defineProps<{
    application_id: string
}>()

const user = usePage().props.auth.user

const application = ref<Application>({})
const loader = ref<boolean>(true)


const form = useForm({
    description: ''
})

const getApplicationData = async () => {
    const { data }  = await axios.get<{data:Application}>(route('application.show',props.application_id))
    application.value = data.data
    loader.value = false
}

const submit = () => {
    form.post(route('application.store'),{
        preserveScroll: true,
        onSuccess: () => form.reset(),
    })
}


onMounted(() => getApplicationData())
</script>

<template>
    <Head :title="$trans('Application Detail')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $trans('Application Detail')}}</h2>
        </template>

        <!-- Loader -->
        <div class="absolute inset-0 bg-gray-400/40 flex justify-center items-center z-50" v-if="loader">
            <div
                class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-e-transparent align-[-0.125em] text-surface motion-reduce:animate-[spin_1.5s_linear_infinite] dark:text-white"
                role="status">
                <span
                    class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
                >Loading...</span>
            </div>
        </div>

        <div class="py-12 space-y-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div class="ms-3">
                            <h3
                                class="mb-6 text-2xl font-bold text-neutral-700 dark:text-neutral-300">
                                {{ $trans('Applicant Information') }}
                            </h3>

                            <div class="flex justify-between w-full gap-2 text-center">
                                <div>
                                    {{ $trans('Name Surname') }} <br>
                                    {{ application.user?.name }}
                                </div>
                                <div>
                                    {{ $trans('Phone') }} <br>
                                    {{ application.user?.phone }}
                                </div>
                                <div>
                                    {{ $trans('E-Mail') }} <br>
                                    {{ application.user?.email }}
                                </div>
                                <div>
                                    {{ $trans('Application Type') }} <br>
                                    {{ application.type }}
                                </div>
                            </div>
                            <div class="mt-2">
                                {{ $trans('Location') }} :
                                {{ application.location?.name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3
                            class="mb-6 ms-3 text-2xl font-bold text-neutral-700 dark:text-neutral-300">
                            {{ $trans('Application Process History') }}
                        </h3>

                        <ol class="ml-6 border-s-2 border-blue-100">
                            <!--First item-->
                            <li v-if="application.source">
                                <div class="flex-start md:flex">
                                    <div
                                        class="-ms-6 flex-none h-12 w-12 p-3 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                                        <PlusIcon class="w-6 h-6" />
                                    </div>
                                    <div
                                        class="mb-10 ms-6 block w-full rounded-lg bg-neutral-50 p-6 shadow-md shadow-black/5 dark:bg-neutral-700 dark:shadow-black/10">
                                        <div class="mb-4 flex justify-between">
                                            <span
                                                class="text-sm text-info transition duration-150 ease-in-out hover:text-info-600 focus:text-info-600 active:text-info-700"
                                            >{{ application.source }}</span>
                                            <span
                                                class="text-sm text-info transition duration-150 ease-in-out hover:text-info-600 focus:text-info-600 active:text-info-700"
                                            >{{ application.created_at }}</span>
                                        </div>
                                        <p class="mb-6 text-neutral-700 dark:text-neutral-200">
                                            {{ application.description }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        İşlem Mesajı
                        <TextAreaInput class="w-full" v-model="form.description" rows="5" />

                        <div class="space-x-2">
                            <Assignment />
                            <PrimaryButton>Cevapla ve Kapat</PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </AuthenticatedLayout>
</template>

<style scoped>

</style>
