<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeTextarea from '@/Components/Textarea.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
    errors: Object,
    gebruikers: {},
});


const form = useForm({
    casus_id: '',
    plaats: '',
    datum_incident: '',
    omschrijving: '',
    interne_betrokkenen: [],
});

const submit = () => {
    form.post(route('dossier.store'));
};
</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>

        <template #header>
            <div class="flex flex-row justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight py-2 px-4">Cases - Nieuw</h2>
                <div class="">
                </div>
            </div>
        </template>

        <div class="py-12">
            <form @submit.prevent="submit">
                <div class="flex flex-col md:flex-row sm:space-y-4 md:space-y-0 md:space-x-4 pl-3 pr-3">
                    <div class="w-full md:w-1/3 mx-auto sm:px-6 lg:px-0 sm:py-6 lg:py-0">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="flex flex-col">
                                    <h3 class="font-semibold text-xl pb-4">Algemeen</h3>
                                    <div class="space-y-4">
                                        <div class="">
                                            <BreezeLabel for="casus_id" value="Casus ID"/>
                                            <BreezeInput id="casus_id" type="text" class="mt-1 block w-full"
                                                         v-model="form.casus_id"
                                                         autocomplete="off"
                                                         placeholder="Bijvoorbeeld: NDFT324"/>
                                            <div v-if="errors.casus_id" class="text-red-600 font-semibold pt-4">{{ errors.casus_id }}</div>
                                        </div>
                                        <div class="">
                                            <BreezeLabel for="plaats" value="Plaats"/>
                                            <BreezeInput id="plaats" type="text" class="mt-1 block w-full"
                                                         v-model="form.plaats"
                                                         autocomplete="off"
                                                         placeholder="Bijvoorbeeld: Enschede"/>
                                            <div v-if="errors.plaats" class="text-red-600 font-semibold pt-4">{{ errors.plaats }}</div>
                                        </div>
                                        <div class="">
                                            <BreezeLabel for="datum_incident" value="Datum incident"/>
                                            <BreezeInput id="datum_incident" type="date" class="mt-1 block w-full"
                                                         v-model="form.datum_incident"
                                                         autocomplete="off"/>
                                            <div v-if="errors.datum_incident" class="text-red-600 font-semibold pt-4">{{ errors.datum_incident }}</div>
                                        </div>
                                        <div class="">
                                            <BreezeLabel for="omschrijving" value="Omschrijving"/>
                                            <BreezeTextarea id="omschrijving" class="mt-1 block w-full"
                                                            v-model="form.omschrijving"
                                                            autocomplete="off"/>
                                            <div v-if="errors.omschrijving" class="text-red-600 font-semibold pt-4">{{ errors.omschrijving }}</div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 mx-auto sm:px-6 lg:px-0 sm:py-6 lg:py-0">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="flex flex-col">
                                    <h3 class="font-semibold text-xl pb-4">Interne Betrokkenen</h3>

                                    <ul>
                                        <li v-for="gebruiker in gebruikers" :key="gebruiker.id">
                                            <input
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                type="checkbox" :id="gebruiker.naam" :value="gebruiker.naam"
                                                v-model="form.interne_betrokkenen"> -
                                            <label :for="gebruiker.naam">{{ gebruiker.naam }}</label>
                                        </li>
                                    </ul>
                                    <div v-if="errors.interne_betrokkenen" class="text-red-600 font-semibold pt-4">{{ errors.interne_betrokkenen }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 mx-auto sm:px-6 lg:px-0 sm:py-6 lg:py-0">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h3 class="font-semibold text-xl pb-4">Samenvatting</h3>
                                <table class="w-full align-text-top">
                                    <tr>
                                        <td class="w-1/2 font-semibold">Casus ID:</td>
                                        <td class="w-1/2">{{ form.casus_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-1/2 font-semibold">Plaats:</td>
                                        <td class="w-1/2">{{ form.plaats }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-1/2 font-semibold">Datum Incident:</td>
                                        <td class="w-1/2">{{ form.datum_incident }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-1/2 font-semibold">Omschrijving:</td>
                                        <td class="w-1/2">{{ form.omschrijving }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-1/2 font-semibold">Interne betrokkenen:</td>
                                        <td class="w-1/2">
                                            <ul>
                                                <li v-for="check in form.interne_betrokkenen">{{ check }}</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-1/2 font-semibold">&nbsp;</td>
                                        <td class="w-1/2">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="w-1/2 font-semibold">&nbsp;</td>
                                        <td class="w-1/2">
                                            <button
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                                type="submit">
                                                Opslaan
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </BreezeAuthenticatedLayout>
</template>
