<script setup lang="ts">
import { ref, watch } from 'vue';
import { debounce } from 'lodash';
import { Head, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PaginationTable from '@/Components/PaginationTable.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const tableHeaders = [
    { title: 'Name', key: 'name' },
    { title: 'Description', key: 'description' },
    { title: 'Rating', key: 'stargazers_count' },
    { title: 'Actions', key: '' }
];

const search = ref('');
const sort = ref('stars');
const order = ref('desc');
const perPage = ref(15);
const page = ref(1);

const props = defineProps({
  repositories: JSON,
  searchTerm: String
});

/*watch(search, debounce((value) => {
  
  Inertia.get(route('github.search'), { searchTerm: value }, {
    preserveState: true, // Keep the search term in the URL across pagination
    replace: true, // Replace the current history entry
  });
}, 500)); // 500ms delay*/

function onPageChange(payload) {
  page.value = payload;
  search.value = props.searchTerm;
  searchRepositories();

}
function searchRepositories() {
  Inertia.get(route('github.search'), { searchTerm: search.value, sort: sort.value, order: order.value, perPage: perPage.value, page: page.value }, {
    preserveState: true, // Keep the search term in the URL across pagination
    replace: true, // Replace the current history entry
  });

  console.log(props.repositories);
} // 500ms delay

</script>

<template>
    <Head title="Github Search" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Github Search
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                  <div class="flex">
                  <TextInput
                    id="search"
                    type="search"
                    class="mt-1 block w-full"
                    v-model="search"
                    required
                    placeholder="Search GitHub"
                  />
                  <!---<input type="search" v-model="search" placeholder="Search GitHub repositories..." />-->
                  <PrimaryButton class="ml-5" @click="searchRepositories" :disabled="search == ''">Search</PrimaryButton>
                  

                  <Link class="ml-5 inline-flex items-center text-sm font-medium leading-5 text-gray-900 dark:text-gray-100">View Favorites</Link>
                 </div>
                  <!---<button @click="searchRepositories">Search</button>-->
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                  <!--<ul>
                    <li v-for="repo in repositories.items" :key="repo.id">
                      <a :href="repo.html_url" target="_blank">{{ repo.name }}</a>
                      <p>{{ repo.description }}</p>
                    </li>
                  </ul>-->
                  <PaginationTable :headers="tableHeaders" 
                      :items="repositories.items"
                      :page="page.value"
                      :itemsPerPage="perPage.value" 
                      :itemsTotal="repositories.total_count"
                      @pageChange="onPageChange"
                      >
                  </PaginationTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>