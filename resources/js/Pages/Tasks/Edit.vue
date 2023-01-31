<template>
    <AppLayout2>
        <form @submit.prevent="form.put(route('tasks.update', task.id))">
            <label for="name">{{ $t('tasks.create.name') }}</label> <br />
            <input v-model="form.name" type="text" id="name" /> <br />
            <div v-if="form.errors.name">{{ form.errors.name }}</div>
            <label for="deadline">{{ $t('tasks.create.deadline') }}</label> <br />
            <input
                v-model="form.deadline"
                type="datetime-local"
                id="deadline"
            /> <br />
            <div v-if="form.errors.deadline">{{ form.errors.deadline }}</div>
            <label for="description">{{ $t('tasks.create.description') }}</label> <br />
            <textarea
                v-model="form.description"
                ows="5"
                cols="10"
                id="description"
            ></textarea> <br />
            <div v-if="form.errors.description">
                {{ form.errors.description }}
            </div>
            <button type="submit">{{ $t('tasks.create.button') }}</button>
        </form>
    </AppLayout2>
</template>

<script>
import AppLayout2 from "../../Layouts/AppLayout2.vue";
import { router, useForm } from "@inertiajs/vue3";

export default {
    name: "Edit",
    components: { AppLayout2 },
    props: {
        task: { type: Object },
    },
    data() {
        return {
            form: useForm({
                name: "",
                description: "",
                deadline: "",
            }),
        };
    },
    methods: {
        submit() {
            router.put(this.route("tasks.update", this.task.id), this.form);
        },
    },
    mounted() {
        for (const [key, val] of Object.entries(this.task)) {
            this.form[key] = val;
        }
    },
};
</script>

<style scoped></style>
