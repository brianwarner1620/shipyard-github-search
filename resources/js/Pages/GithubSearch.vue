<script setup lang="ts">
import { ref, watch } from 'vue';

import { Head, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PaginationTable from '@/Components/PaginationTable.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const tableHeaders = [
    { title: 'Repo Id', key: 'id' },
    { title: 'Name', key: 'name' },
    { title: 'Owner', key: 'owner.login' },
    { title: 'Description', key: 'description' },
    { title: 'Rating', key: 'stargazers_count' },
    { title: 'Actions', key: '' }
];

const search = ref('');
const sort = ref('stars');
const order = ref('desc');
const perPage = ref(15);

const props = defineProps({
  repositories: Object,
  page: Number
});

function handlePageChange(newPage) {
  Inertia.reload({
    only: ['repositories', 'page'],
    data: {
      page: newPage
    }
  });
}
function searchRepositories() {
  Inertia.get(route('github.search'), { searchTerm: search.value, sort: sort.value, order: order.value, perPage: perPage.value, page: 1 }, {
    preserveState: true, // Keep the search term in the URL across pagination
    replace: true, // Replace the current history entry
  });
} 
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
                  <PrimaryButton class="ml-5" @click="searchRepositories" :disabled="search == ''">Search</PrimaryButton>
                  
                  <Link href="favorite-repos" class="ml-5 inline-flex items-center text-sm font-medium leading-5 text-gray-900 dark:text-gray-100">View Favorites</Link>
                 </div>
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                  <PaginationTable 
                      :headers="tableHeaders" 
                      :items="props.repositories.items"
                      :page="props.page"
                      :itemsPerPage="perPage"
                      :itemsTotal="props.repositories.total_count"
                      @pageChange="handlePageChange"
                      >
                  </PaginationTable>

                  <!---<v-data-table
                    :headers="tableHeaders"
                    :items="favoriteRepos.data"
                    :items-per-page=15
                    :page="props.favoriteRepos.current_page"
                    :items-length="props.favoriteRepos.total"
                    @update:page="handlePageChange"
                  ></v-data-table>-->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>