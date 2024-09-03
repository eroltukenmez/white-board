<script setup lang="ts">
import {ref, watch} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import Multiselect from "@vueform/multiselect";
import axios from "axios";
import InputLabel from "@/Components/InputLabel.vue";

const isAssignmentModalOpen = ref<boolean>(false)
const department = ref<string>('');
const user = ref<string>('')

const fetchDepartment = async (query:any) => {
    const data = await axios.get(route('departments.data'),{
        params:{query}
    })
    return data.data.data
}
const fetchUser = async (query:any) => {
    const data = await axios.get(route('departments.data'),{
        params:{query,department:department.value}
    })

    return data.data.data
}

</script>

<template>
    <PrimaryButton @click="isAssignmentModalOpen = true">{{ $trans('Assignment') }}</PrimaryButton>


    <Modal :show="isAssignmentModalOpen" @close="isAssignmentModalOpen = false">
        <div class="w-full h-[calc(100vh-80px)] p-4 space-y-4">
            <p class="text-md dark:text-gray-400">
                <ul class="space-y-2 list-disc list-inside">
                    <li>Yönlendirme yapmak için Departman ya da doğrudan kullanıcı seçebilirsiniz.</li>
                    <li>Departman seçildiğinde ilgi departmana bağlı bütün kullanıcılar başvuruyu görebilir ve yanıtlama yapabilir.</li>
                    <li>Kullanıcı seçililmesi halinde sadece seçilen kullanıcı ilgili başvuruyu görebilir ve yanıtlayabilir.</li>
                </ul>
            </p>

            <div>
                <InputLabel for="department" :value="$trans('Department')" />
                <Multiselect id="department" v-model="department"
                             :filter-results="false"
                             :min-chars="2"
                             :resolve-on-load="true"
                             :limit="10"
                             :delay="0"
                             :searchable="true"
                             :options="fetchDepartment" value-prop="id" label="name" :classes="{}"/>
            </div>
            <div>
                <InputLabel for="user" :value="$trans('User')" />
                <Multiselect id="user" v-model="user" :options="fetchUser" value-prop="id" label="name" />
            </div>


        </div>
    </Modal>

</template>

<style scoped>

</style>
