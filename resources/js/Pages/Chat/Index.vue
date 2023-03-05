<template>
    <div>OpenAI Hustling: Ask something to ChatGPT</div>

    <div>
        <form @submit.prevent="submit">
            <div>
                <input
                    type="text"
                    class=""
                    name="prompt"
                    placeholder="Ask something..."
                    v-model="form.prompt"
                >
            </div>

            <div>
                Answer is {{ answer }}
            </div>

            <button
                type="submit"
                class=""
            >Send</button>
        </form>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';

const form = ref({
    prompt: '',
});

const answer = ref('');

const submit = () => {
    axios
        .post('/chatgpt/ask', form.prompt.value)
        .then((response) => {
            answer.value = response.choices[0].text;
        })
        .catch((error) => {
            console.log('whoopsy', error);
        });
};
</script>
