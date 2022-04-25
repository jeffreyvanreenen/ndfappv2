<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head} from '@inertiajs/inertia-vue3';
import {Link} from '@inertiajs/inertia-vue3';

defineProps({
    items: {},
    curpage: {},
});


</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight py-2 px-4">Items - {{ curpage }}</h2>
                <div class="">
                    <Link :href="route('rss.create')">
                        <button
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="button">
                            Nieuwe Bron
                        </button>
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12 flex flex-col space-y-4">

            <div v-if="$page.props.flash.message" class="w-full mx-auto sm:px-6 lg:px-8" role="alert">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div
                        class="p-6 border-b border-green-500 text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800">
                        {{ $page.props.flash.message }}
                    </div>
                </div>
            </div>

            <div class="w-full mx-auto sm:px-6 lg:px-8">

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Titel
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Omschrijving
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Publicatie Datum
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Auteur
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Instellingen</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="item in items" :key="item.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ item.title }}
                            </th>
                            <td class="px-6 py-4">
                                {{ item.description }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.pubDate }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.author }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a :href="item.link" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Open</a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>

            </div>


        </div>
    </BreezeAuthenticatedLayout>
</template>
