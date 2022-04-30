<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeTextarea from '@/Components/Textarea.vue';
import {Link} from '@inertiajs/inertia-vue3';



const props = defineProps({
    errors: Object,
    zoekopdracht: {},
    zoekresultaten: {},
});

const form = useForm({
    name: props.zoekopdracht.name,
    kleur: props.zoekopdracht.color,
    zoekopdracht: props.zoekopdracht.searchstring,
});

const submit = () => {
    form.put(route('searchstring.update', zoekopdracht.id));
};
</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Zoekopdracht {{ form.name }}
            </h2>
        </template>

        <div class="py-12">
            <div v-if="$page.props.flash.message" class="w-full mx-auto sm:px-6 lg:px-8" role="alert">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div
                        class="p-6 border-b border-green-500 text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800">
                        {{ $page.props.flash.message }}
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row sm:space-y-4 md:space-y-0 md:space-x-4 pl-3 pr-3">
                <div class="w-full md:w-1/2 mx-auto sm:px-6 lg:px-0 sm:py-6 lg:py-0">
                    <form @submit.prevent="submit">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="flex flex-col">
                                    <h3 class="font-semibold text-xl pb-4">Zoekopdracht bewerken</h3>
                                    <div class="space-y-4">
                                        <div class="">
                                            <BreezeLabel for="name" value="Naam"/>
                                            <BreezeInput id="name" type="text" class="mt-1 block w-full"
                                                         v-model="form.name"
                                                         autocomplete="off"
                                                         placeholder=""/>
                                            <div v-if="errors.name" class="text-red-600 font-semibold pt-4">
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                        <div class="">
                                            <BreezeLabel for="kleur" value="Kleur"/>
                                            <BreezeInput id="kleur" type="color" class="mt-1 block w-full"
                                                         v-model="form.kleur"
                                                         autocomplete="off" />
                                            <div v-if="errors.kleur" class="text-red-600 font-semibold pt-4">
                                                {{ errors.kleur }}
                                            </div>
                                        </div>
                                        <div class="">
                                            <BreezeLabel for="zoekopdracht" value="Zoekopdracht"/>
                                            <BreezeTextarea id="zoekopdracht" class="mt-1 block w-full"
                                                            v-model="form.zoekopdracht"
                                                            autocomplete="off"/>
                                            <div v-if="errors.zoekopdracht" class="text-red-600 font-semibold pt-4">{{ errors.zoekopdracht }}</div>

                                        </div>
                                        <div>
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
                    </form>
                </div>

                <div class="w-full md:w-1/2 mx-auto sm:px-6 lg:px-0 sm:py-6 lg:py-0">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex flex-col">
                                <h3 class="font-semibold text-xl pb-4">Zoekresultaten</h3>
                                <div class="space-y-4" v-for="zoekresultaat in zoekresultaten" :key="zoekresultaat.id">
                                    {{ zoekresultaat.title}} - {{ zoekresultaat.description }}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </BreezeAuthenticatedLayout>
</template>
