<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mt-4">Edit API: Fix text with ChatGPT</h1>

        <div class="mt-8">
            <form @submit.prevent="submit">
                <div class="relative">
                    <label
                        for="prompt"
                        class="absolute -top-2 left-2 inline-block bg-white px-1 text-xs font-medium text-gray-900"
                    >Prompt</label>
                    <div class="mt-2">
                        <input
                            type="text"
                            name="prompt"
                            id="prompt"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-3"
                            placeholder="Edit something..."
                            v-model="form.prompt"
                        />
                    </div>
                </div>

                <div class="sm:col-span-2 mt-8 ml-1">
                    <dt class="text-sm font-medium text-gray-500">Correction</dt>
                    <dd
                        class="mt-1 max-w-prose space-y-5 text-sm text-gray-900"
                        v-html="answer"
                    />
                </div>

                <button
                    type="submit"
                    :disabled="isAnswering"
                    class="mt-4 rounded-md bg-indigo-600 py-1.5 px-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50"
                >Send prompt</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';

const form = ref({
    prompt: '',
});

const answer = ref('...');

const isAnswering = ref(false);

const submit = () => {
    isAnswering.value = true;

    axios
        .post('/chatgpt/edit', form.value)
        .then((response) => {
            isAnswering.value = false;
            answer.value = response.data.choices[0].text;
        })
        .catch((error) => {
            isAnswering.value = false;
            answer.value = "Something went wrong, it couldn't find an answer."
            console.log('whoopsy', error);
        });
};
</script>
