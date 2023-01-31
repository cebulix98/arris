<template>
    <Head :title="title" />
    <div class="app-layout">
        <NavBar></NavBar>
        <div class="workspace">
            <slot />
        </div>
    </div>
</template>

<script options>
import NavBar from '../Components/NavBar.vue';
import { Head} from "@inertiajs/vue3";

export default {
    name: 'AppLayout2',
    components: {NavBar, Head},
    props: {
        title: String
    }
}

</script>

<style scoped>
.app-layout {
    width: 100%;
    height: 100vh;
    display: grid;
    grid-template-columns: 100%;
    grid-template-rows: 75px auto;
}
.workspace{
    position: relative;
    display: grid;
    grid-template-columns: 100%;
    grid-auto-rows: min-content;
    grid-row-gap: 10px;
    overflow-y: scroll;
    overflow-x: hidden;
    border: 1px solid #999;
    padding: 10px 10px 0px 10px;
    box-shadow: 1px 1px 5px -1px rgb(0 0 0 / 50%);
}

</style>
