<template>
    <AppLayout2>
        <CustomFilters
            :filters="filters"
            @filtersApplied="getTasks"
        ></CustomFilters>
        <div class="tasks-list floating-tile">
            <div class="tasks-list-headers">
                <div>{{ $t("tasks.table.name") }}</div>
                <div>{{ $t("tasks.table.deadline") }}</div>
                <div>{{ $t("tasks.table.status") }}</div>
            </div>
            <div
                v-for="(task, key) in tasks"
                :key="refreshKeys.table + key"
                class="task-list-item"
            >
                <div
                    v-if="!task.description"
                    class="clickable"
                    @click="showDescription(task.id, key)"
                >
                    {{ task.name }}
                </div>
                <div v-else>{{ task.name }}</div>
                <div>{{ task.deadline }}</div>
                <div @click="toggleStatus(task.id, key)" class="clickable">
                    {{ completed(task.completed) }}
                </div>
                <div class="task-description" v-if="task.description">
                    {{ task.description }}
                </div>
            </div>
        </div>
    </AppLayout2>
</template>

<script>
import AppLayout2 from "@/Layouts/AppLayout2.vue";
import CustomFilters from "@/Components/CustomFilters.vue";

export default {
    name: "Index",
    components: {
        AppLayout2,
        CustomFilters,
    },
    props: {
        inertiaTasks: { type: Array },
    },
    data() {
        return {
            filters: {
                name: { type: "text", label: "tasks.filter.name" },
                search: { type: "text", label: "tasks.filter.search" },
                deadlineFrom: {
                    type: "dateTime",
                    label: "tasks.filter.deadlineFrom",
                },
                deadlineTo: {
                    type: "dateTime",
                    label: "tasks.filter.deadlineTo",
                },
                sortBy: {
                    type: "select",
                    label: "tasks.filter.sorting",
                    options: [
                        { value: "name_asc", label: "tasks.sorting.nameAsc" },
                        { value: "name_desc", label: "tasks.sorting.nameDesc" },
                        {
                            value: "deadline_asc",
                            label: "tasks.sorting.deadlineAsc",
                        },
                        {
                            value: "deadline_desc",
                            label: "tasks.sorting.deadlineDesc",
                        },
                    ],
                },
            },
            tasks: [],
            editor: false,
            refreshKeys: {
                table: 1,
            },
            formData: {},
        };
    },
    methods: {
        getTasks(filters) {
            axios
                .get(`api/tasks/filtered?${this.makeQueryString(filters)}`)
                .then((res) => {
                    this.tasks = res.data;
                    this.refreshKeys.table++;
                })
                .catch((error) => console.log(error));
        },
        makeQueryString(params) {
            console.log(params);
            return Object.keys(params)
                .filter((key) => params[key] !== null)
                .map((key) => key + "=" + params[key])
                .join("&");
        },
        showDescription(id, key) {
            fetch(`api/tasks/description/${id}`)
                .then((response) => response.json())
                .then((data) => {
                    this.tasks[key].description = data.description;
                })
                .catch((error) => console.log(error));
        },
        toggleStatus(id, key) {
            if (!confirm(this.$t("tasks.toggleStatus.confirmation")))
                return false;
            axios
                .patch(`api/tasks/toggle-status/${id}`)
                .then((response) => {
                    this.tasks[key].completed =
                        this.tasks[key].completed == false;
                })
                .catch((error) => console.log(error));
        },
        completed(status) {
            return status ? "V" : "X";
        },
    },
    mounted() {
        this.tasks = this.inertiaTasks.map((task) => task);
    },
};
</script>

<style scoped>
.tasks-list {
    margin: 0 30%;
    display: grid;
    grid-template-columns: 100%;
    grid-auto-rows: max-content;
    font-size: 26px;
    line-height: 40px;
}
.task-list-item,
.tasks-list-headers {
    display: grid;
    grid-template-columns: 2fr 2fr 120px;
    text-align: center;
    border-bottom: 1px solid #999;
}
.tasks-list .task-list-item:nth-child(even) {
    background: #d0e4f5;
}
.task-description {
    grid-column: 1/4;
    border-top: 1px solid #999;
}
</style>
