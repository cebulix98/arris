<template>
    <AppLayout2>
        <form @submit.prevent="submit" method="post">
            <input v-model="form.name" type="text" id="name">
            <div v-if="form.errors.name">{{ form.errors.name }}</div>

            <input v-model="form.deadline" type="datetime-local" id="deadline">
            <div v-if="form.errors.deadline">{{ form.errors.deadline }}</div>

            <textarea v-model="form.description" ows="5" cols="10" id="description"></textarea>
            <div v-if="form.errors.description">{{ form.errors.description }}</div>

            <input type="submit" :value="$t('task.create.button')">
    <button type="submit">Submit</button>
        </form>
    </AppLayout2>
</template>

<script>
import AppLayout2 from '../../Layouts/AppLayout2.vue';
import { router, useForm } from "@inertiajs/vue3";

    export default {
    name: "Create",
    components: { AppLayout2 },
    data() {
        return {
            'form': useForm({
                'name': '',
                'description': '',
                'deadline': ''
            })
        }
    },
    methods: {
        submit() {
        router.post(this.route('tasks.store'), this.form)
        },
    },
}
</script>

<style scoped>

</style>
