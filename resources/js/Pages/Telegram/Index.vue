<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';

defineProps({
    errors: Object,
    bots: {},
});


const form = useForm({
    name: '',
    token: '',
});

const submit = () => {
    form.post(route('telegram.store'));
};
</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
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
                                    <h3 class="font-semibold text-xl pb-4">Nieuwe Telegram Bot</h3>
                                    <div class="space-y-4">
                                        <div class="">
                                            <BreezeLabel for="name" value="Naam"/>
                                            <BreezeInput id="name" type="text" class="mt-1 block w-full"
                                                         v-model="form.name"
                                                         autocomplete="off"
                                                         placeholder="Bijvoorbeeld: Jeffrey"/>
                                            <div v-if="errors.name" class="text-red-600 font-semibold pt-4">
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                        <div class="">
                                            <BreezeLabel for="token" value="Token"/>
                                            <BreezeInput id="token" type="text" class="mt-1 block w-full"
                                                         v-model="form.token"
                                                         autocomplete="off"
                                                         placeholder=""/>
                                            <div v-if="errors.token" class="text-red-600 font-semibold pt-4">
                                                {{ errors.token }}
                                            </div>
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
                                <h3 class="font-semibold text-xl pb-4">Actieve Bots</h3>
                                <div class="space-y-4">
                                    <ul>
                                        <li v-for="bot in bots">{{ bot.name }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </BreezeAuthenticatedLayout>
</template>
