<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeTextarea from '@/Components/Textarea.vue';


defineProps({
    errors: Object,
    chats: {},
});

// const interval = setInterval(function () {
//     Inertia.reload({only: ['chats'], preserveScroll: true});
// }, 10000);

const destroyinterval = clearInterval()
const form = useForm({
    reply: '',
    reply_id: '',

});

const submit = () => {
    // form.post(route('dossier.store'));
    console.log(reply);
    console.log(reply_id);
};

Echo.channel(`messages`)
    .listen('.newMessage', (message) => {
        console.log(message);
        Inertia.reload({only: ['chats'], preserveScroll: true});
    });
</script>

<template>

    <Head title="Dashboard"/>
    <BreezeAuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12 h-screen">
            <div v-if="$page.props.flash.message" class="w-full mx-auto sm:px-6 lg:px-8" role="alert">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div
                        class="p-6 border-b border-green-500 text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800">
                        {{ $page.props.flash.message }}
                    </div>
                </div>
            </div>

            <div
                class="flex flex-col md:flex-row sm:space-y-4 md:space-y-0 md:space-x-4 pl-3 pr-3 overflow-x-auto h-full">
                <div v-for="chat in chats" :key="chat.id" class="w-1/4 flex-none h-full h-full">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6 bg-white border-b border-gray-200 h-full overflow-y-auto">
                            <div class="flex flex-col h-full">
                                <h3 class="font-semibold text-xl pb-4">Chat - {{ chat.title }} ({{ chat.type }})</h3>
                                    <div class="flex space-y-4">
                                        <ul>
                                            <li v-for="message in chat.messages" :key="message.id">
                                            <span
                                                class="inline-block bg-gray-100 rounded-full px-3 py-1 text-gray-700 mr-2 mb-2">
                                                <div class="text-xs text-red-500 font-bold">{{
                                                        message.user_first_name
                                                    }} {{ message.user_last_name }} - {{ message.date }}</div>
                                                <div class="pt-3">{{ message.text }}</div>
                                            </span>
                                            </li>
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
