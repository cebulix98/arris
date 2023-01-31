<template>
    <AppLayout2>
        <form @submit.prevent="submit" method="post">
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
    name: "Create",
    components: { AppLayout2 },
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
            router.post(this.route("tasks.store"), this.form);
        },
    },
};
</script>

<style scoped></style>
