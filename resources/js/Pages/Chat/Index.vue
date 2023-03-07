<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mt-4">Chat API: Talk to ChatGPT</h1>

        <div class="mt-4">
            <form @submit.prevent="submit">
                <div class="sm:col-span-2 mt-8 ml-2">
                    <div v-for="message in form.messages">
                        <dt class="mt-2 text-sm font-medium text-gray-500">{{ message.role }}</dt>
                        <dd
                            class="mt-1 max-w-prose space-y-5 text-sm text-gray-900"
                            v-html="message.content"
                        />
                    </div>
                </div>

                <div class="mt-8 relative">
                    <label
                        for="prompt"
                        class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900"
                    >Question</label>
                    <div class="mt-2">
                        <input
                            type="text"
                            name="prompt"
                            id="prompt"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-3"
                            placeholder="Ask something..."
                            v-model="prompt"
                        />
                    </div>
                </div>

                <button
                    type="submit"
                    :disabled="isAnswering"
                    class="mt-4 rounded-md bg-indigo-600 py-1.5 px-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50"
                >Send question</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, reactive } from 'vue';

const form = reactive({
    messages: [],
});

const prompt = ref('');
const isAnswering = ref(false);

const submit = () => {
    if (!prompt.value) {
        return;
    }

    isAnswering.value = true;

    form.messages.push({
        role: 'user',
        content: prompt.value,
    });

    prompt.value = '';

    axios
        .post('/chatgpt/chat', form)
        .then((response) => {
            isAnswering.value = false;
            form.messages.push(response.data.choices[0].message);
        })
        .catch((error) => {
            isAnswering.value = false;
            console.log('whoopsy', error);
        });
};
</script>
