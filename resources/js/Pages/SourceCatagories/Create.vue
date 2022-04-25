<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeTextarea from '@/Components/Textarea.vue';

defineProps({
    errors: Object,

});

const form = useForm({
    name: '',
    description: '',
    image_url: '',
});

const submit = () => {
    form.post(route('sources.store'));
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
                                        <BreezeLabel for="image_url" value="Afbeelding URL"/>
                                        <BreezeInput id="image_url" type="text" class="mt-1 block w-full"
                                                     v-model="form.image_url"
                                                     autocomplete="off"
                                                     placeholder="http://*"/>
                                        <div v-if="errors.image_url" class="text-red-600 font-semibold pt-4">
                                            {{ errors.image_url }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <BreezeLabel for="description" value="Omschrijving"/>
                                        <BreezeTextarea id="description" class="mt-1 block w-full"
                                                        v-model="form.description"
                                                        autocomplete="off"/>
                                        <div v-if="errors.description" class="text-red-600 font-semibold pt-4">
                                            {{ errors.description }}
                                        </div>
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
