<template>
  <div class="nav-bar">
  <div></div>
    <div class="nav-links">
        <div>
            <Link :href="route('tasks.index')">{{ $t('navBar.main') }}</Link>
        </div>
        <div>
            <Link :href="route('tasks.create')">{{ $t('navBar.add') }}</Link>
        </div>
    </div>
    <div>
      <Dropdown align="right" width="48">
        <template #trigger>
          <span class="inline-flex rounded-md">
            <button
              type="button"
              class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition"
            >
              {{ $page.props.user.name }}
            </button>
          </span>
        </template>

        <template #content>
          <!-- Account Management -->
          <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>

          <DropdownLink :href="route('profile.show')"> Profile </DropdownLink>

          <div class="border-t border-gray-100" />

          <!-- Authentication -->
          <form @submit.prevent="logout">
            <DropdownLink as="button"> Log Out </DropdownLink>
          </form>
        </template>
      </Dropdown>
    </div>
  </div>
</template>

<script>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link, router } from "@inertiajs/vue3";

export default {
  name: "NavBar",
  components: {
    Dropdown, DropdownLink, Link
  }
};
</script>

<style scoped>
.nav-bar {
  display: grid;
  grid-template-columns: 100px 5fr 100px;
  box-shadow: 0px 3px 3px rgb(0 0 0 / 50%);
  grid-column: 1/3;
}

img {
  max-width: 100%;
  max-height: 100%;
  width: auto;
  height: auto;
}

.nav-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 100%;
    text-align: center;
    line-height: 75px;
}
</style>
