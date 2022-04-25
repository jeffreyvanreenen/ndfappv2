<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';

defineProps({
    errors: Object,
    sourcecategorys: {},

});

const form = useForm({
    url: '',
    sourcecategorys: [],
});

const submit = () => {
    form.post(route('rss.store'));
};
</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>

        <template #header>
            <div class="flex flex-row justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight py-2 px-4">Bronnen - RSS - Nieuw</h2>
                <div class="">
                </div>
            </div>
        </template>

        <div class="py-12">
            <div v-if="$page.props.flash.error" class="w-full mx-auto sm:px-6 lg:px-8" role="alert">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div
                        class="p-6 border-b border-green-500 text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800">
                        {{ $page.props.flash.error }}
                    </div>
                </div>
            </div>

            <form @submit.prevent="submit">
                <div class="flex flex-col md:flex-row sm:space-y-4 md:space-y-0 md:space-x-4 pl-3 pr-3">

                    <div class="w-full md:w-1/3 mx-auto sm:px-6 lg:px-0 sm:py-6 lg:py-0">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h3 class="font-semibold text-xl pb-4">Algemeen</h3>
                                <div class="space-y-4">
                                    <div class="">
                                        <BreezeLabel for="casus_id" value="URL naar RSS Feed"/>
                                        <BreezeInput id="casus_id" type="text" class="mt-1 block w-full"
                                                     v-model="form.url"
                                                     autocomplete="off"
                                                     placeholder="http://*"/>
                                        <div v-if="errors.url" class="text-red-600 font-semibold pt-4">
                                            {{ errors.url }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <BreezeLabel value="Bron Categorie"/>
                                        <ul>
                                            <li v-for="sourcecategoryie in sourcecategorys" :key="sourcecategoryie.id">
                                                <input
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                    type="checkbox" :id="sourcecategoryie.name" :value="sourcecategoryie.id"
                                                    v-model="form.sourcecategorys">
                                                <label :for="sourcecategoryie.name"> - {{ sourcecategoryie.name }}</label>
                                            </li>
                                        </ul>
                                        <div v-if="errors.interne_betrokkenen" class="text-red-600 font-semibold pt-4">{{ errors.interne_betrokkenen }}</div>
                                    </div>
                                    <div class="">
                                        <button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                            type="submit">
                                            Opslaan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </BreezeAuthenticatedLayout>
</template>
