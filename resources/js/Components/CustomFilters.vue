<template>
    <div class="custom-filters floating-tile">
        <div class="custom-filters-inputs" :key="filtersData">
            <div class="custom-filters-input-container" v-for="filter, key in filters">
                <label>{{ $t(filter.label) }}</label> <br>
                <input type="text" v-model="filtersData[key]" v-if="filter.type === 'text'">
                <input type="number" v-model="filtersData[key]" v-if="filter.type === 'number'">
                <input type="datetime-local" v-model="filtersData[key]" v-if="filter.type === 'dateTime'">
                <select v-model="filtersData[key]" v-if="filter.type === 'select'">
                    <option v-for="option, key in filter.options" :value="option.value" :key="key">{{ $t(option.label) }}</option>
                </select>
            </div>
        </div>
            <div class="custom-filters-button-container">
                <button @click="applyFilters">{{ $t('filter.button') }}</button>
            </div>
    </div>
</template>
<script>
export default {
    name: "CustomFilters",
    props: {
        filters: {type: Object}
    },
    data() {
        return {
            filtersData: {}
        }
    },
    methods: {
        populateFiltersData() {
            for(const [key, value] of Object.entries(this.filters)) {
                this.filtersData[key] = null;
            }
        },
        applyFilters() {
            this.$emit('filtersApplied', this.filtersData);
        }
    },
    created() {
        this.populateFiltersData();
    }
}
</script>
<style scoped>
    .custom-filters {
        display: grid;
        grid-template-columns: 100%;
        text-align: center;
        grid-row-gap: 20px;
        padding: 10px;
    }

    .custom-filters-inputs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    }

    .custom-filters-input-container {
        position: relative;
    }

    .custom-filters-button-container {
        width: 100%;
    }
</style>
