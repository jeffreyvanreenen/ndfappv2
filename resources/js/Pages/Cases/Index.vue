<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head} from '@inertiajs/inertia-vue3';
import {Link} from '@inertiajs/inertia-vue3';

defineProps({
    dossiers: {},
});



</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight py-2 px-4">Cases</h2>
                <div class="">
                    <Link :href="route('dossier.create')">
                        <button
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="button">
                            Nieuwe case
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

                <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-5">



                    <!--Card-->
                    <div v-for="dossier in dossiers" class="rounded overflow-hidden shadow-lg bg-white">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ dossier.casus_id }} - {{ dossier.plaats }}</div>
                            <p class="text-gray-700 text-base">
                                {{ dossier.omschrijving }}
                            </p>
                        </div>

                        <div class="px-6 pt-4 pb-2">
                            <span v-for="interne_betrokkene in JSON.parse(dossier.interne_betrokkenen)" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                #{{ interne_betrokkene }}
                            </span>
                        </div>
                    </div>




                </div>
            </div>


        </div>
    </BreezeAuthenticatedLayout>
</template>
