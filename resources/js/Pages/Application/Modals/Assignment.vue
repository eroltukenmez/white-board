<script setup lang="ts">
import {onMounted, onUpdated, ref, watch} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import Multiselect from "@vueform/multiselect";
import axios from "axios";
import InputLabel from "@/Components/InputLabel.vue";

const isAssignmentModalOpen = ref<boolean>(false)
const department = ref<string>('');
const user = ref<string>('')

const selectOpened = (select$:any) => {
    if (select$.noOptions) {
        select$.resolveOptions();
    }
}

const fetchDepartment = async (query:any) => {
    const data = await axios.get(route('departments.data'),{
        params:{query}
    })
    return data.data.data
}
const fetchUser = async (query:any) => {
    const data = await axios.get(route('departments.data'),{
        params:{query,user:'users'}
    })

    return data.data.data
}

onUpdated(() => {
    department.value = ''
    user.value = ''
})

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
                <Multiselect id="department" v-model="department" :options="fetchDepartment"
                             autocomplete="off"
                             value-prop="id"
                             label="name"
                             :filter-results="false"
                             :close-on-select="false"
                             :resolve-on-load="false"
                             :infinite="true"
                             :min-chars="2"
                             :limit="10"
                             :clear-on-search="true"
                             :delay="0"
                             :searchable="true"
                             :classes="{singleLabelText:'dark:text-white'}"
                             @open="selectOpened"
                />
            </div>
            <div>
                <InputLabel for="user" :value="$trans('User')" />
                <Multiselect id="user" v-model="user" :options="fetchUser" value-prop="id" label="name" :classes="{singleLabelText:'dark:text-white'}" />
            </div>


        </div>
    </Modal>

</template>

<style scoped>

</style>
