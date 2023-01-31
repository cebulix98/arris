<template>
    <table class="custom-table floating-tile">
        <thead>
            <template v-for="key in keys">
                <th v-if="key.sortable" class="custom-table-sortable" @click="changeSorting(key.key)">
                    {{ key.name }} <template v-if="sortBy.key === key.key && sortBy.direction === 'asc'">&#129045;</template> <template v-else-if="sortBy.key === key.key && sortBy.direction === 'desc'">&#129047;</template>
                </th>
                <th v-else>
                    {{ key.name }}
                </th>
                
            </template>
        </thead>
        <tbody v-bind:key="sortBy.refreshKey">
            <tr v-for="value in values">
                <td v-for="key in keys" :key="key.name">
                    {{ value[key.key] }}
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
export default {
    name: 'CustomTable',
    props: {
        keys: {type: Array},
        values: {type: Array}
    },
    data() {
        return {
            sortBy: {
                key: null,
                direction: "asc",
                refreshKey: 1
            }
        }
    },
    methods: {
        changeSorting(key) {
            if(this.sortBy.key === key) {
                this.sortBy.direction = this.sortBy.direction === "asc" ? "desc" : "asc";
            } else {
                this.sortBy.key = key;
            }
            this.$emit('changeSorting', key, this.sortBy.direction);
        }
    }
}
</script>
<style scoped>
.custom-table {
    border: 1px solid #999;
    width: 100%;
    text-align: left;
    border-collapse: collapse;
  }
  .custom-table th {
    border: 1px solid #999;
    padding: 5px 4px;
  }
  .custom-table td {
    border-left: 1px solid #999;
    padding: 5px 4px;
  }
  .custom-table tbody td {
    font-size: 13px;
  }
  .custom-table tr:nth-child(even) {
    background: #D0E4F5;
  }
  .custom-table thead {
      border-bottom: 2px solid #999;
  }
  .custom-table thead th {
    font-size: 15px;
    font-weight: bold;
    color: #000000;
    text-align: left;
  }

  .custom-table-sortable {
    cursor: pointer;
  }
</style>