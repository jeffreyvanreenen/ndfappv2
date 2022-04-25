<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head} from '@inertiajs/inertia-vue3';
import {Link} from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';

defineProps({
    rsses: {},
    date: String,
});


</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight py-2 px-4">Bronnen - RSS Feeds</h2>
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

                <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5">


                    <!--Card-->
                    <div v-for="rss in rsses" :key="rss.id">
                        <Link :href="route('rss.show', rss.title)"
                           class="flex flex-col items-center bg-white rounded-lg border shadow-md md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <img class="w-1/3 md:object-cover rounded-lg md:h-auto md:rounded-none md:rounded-lg"
                                 :src="rss.image_url" alt="">
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ rss.title }}</h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ rss.description }}</p>
                                <p> <span
                                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 text-xs">
                                U:{{ rss.updated_at }}
                            </span></p>
                                <p> <span v-for="source_categories in rss.source_categories" :key="source_categories.id"
                                          class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 text-xs">
                                {{ source_categories.name }}
                            </span></p>
                            </div>
                        </Link>


                    </div>


                </div>
            </div>


        </div>
    </BreezeAuthenticatedLayout>
</template>
