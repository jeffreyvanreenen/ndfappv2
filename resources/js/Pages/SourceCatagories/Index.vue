<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head} from '@inertiajs/inertia-vue3';
import {Link} from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';

defineProps({
    sourcecategories: {},
    date: String,
});


</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight py-2 px-4">Bron Categorieën</h2>
                <div class="">
                    <Link :href="route('sources.create')">
                        <button
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="button">
                            Nieuwe Categorie
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

                <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5">

                    <!--Card-->
                    <div v-for="sourcecategorie in sourcecategories" :key="sourcecategorie.id">
                        <a href="#"
                           class="flex flex-col items-center bg-white rounded-lg border shadow-md md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <img class="w-1/3 md:object-cover rounded-lg md:h-auto md:rounded-none md:rounded-lg"
                                 :src="sourcecategorie.image_url" alt="">
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ sourcecategorie.name }}</h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ sourcecategorie.description }}</p>
                                <p> <span v-for="rss_feed in sourcecategorie.r_s_sfeeds" :key="rss_feed.id"
                                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 text-xs">
                                {{ rss_feed.title }}
                            </span></p>
                            </div>
                        </a>
                    </div>


                </div>
            </div>


        </div>
    </BreezeAuthenticatedLayout>
</template>
