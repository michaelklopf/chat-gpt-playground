<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mt-4">Text completions API: Ask something to ChatGPT</h1>

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
                            placeholder="Ask something..."
                            v-model="form.prompt"
                        />
                    </div>
                </div>

                <fieldset class="sm:col-span-2 mt-8 ml-1">
                    <legend class="text-sm font-medium text-gray-500">Temperature</legend>

                    <input
                        id="temp0"
                        class="peer/temp0"
                        type="radio"
                        name="temperature"
                        v-model="form.temperature"
                        value="0"
                        checked
                    />
                    <label
                        for="temp0"
                        class="ml-1 peer-checked/temp0:text-sky-500"
                    >0</label>

                    <input
                        id="temp05"
                        class="ml-2 peer/temp05"
                        type="radio"
                        name="temperature"
                        v-model="form.temperature"
                        value="0.5"
                    />
                    <label
                        for="temp05"
                        class="ml-1 peer-checked/temp05:text-sky-500"
                    >0.5</label>

                    <input
                        id="temp1"
                        class="ml-2 peer/temp1"
                        type="radio"
                        name="temperature"
                        v-model="form.temperature"
                        value="1"
                    />
                    <label
                        for="temp1"
                        class="ml-1 peer-checked/temp1:text-sky-500"
                    >1</label>
                </fieldset>

                <div class="sm:col-span-2 mt-8 ml-1">
                    <dt class="text-sm font-medium text-gray-500">Answer</dt>
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
    temperature: "0",
});

const answer = ref('...');

const isAnswering = ref(false);

const submit = () => {
    isAnswering.value = true;

    axios
        .post('/chatgpt/ask', form.value)
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
