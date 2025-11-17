<script setup lang="ts">
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Head, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

import PaginationTable from '@/Components/PaginationTable.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const tableHeaders = [
    { title: '', key: '', value: 'id', class: 'd-none', cellClass: 'd-none' },
    { title: 'Repo Id', key: 'repo_id' },
    { title: 'Name', key: 'name' },
    { title: 'Owner', key: 'owner' },
    { title: 'Description', key: 'description' },
    { title: 'Rating', key: 'stargazers_count' },
    { title: 'Actions', key: 'actions', value: 'actions' }
];

const form = useForm({});
const perPage = ref(100);
const props = defineProps({
  favoriteRepos: Object,
  page: Number,
  total: Number
});

function handlePageChange(newPage) {
  Inertia.reload({
    only: ['repositories', 'page', 'total'],
    data: {
      page: newPage
    }
  });
}
function removeFavoriteRepo(item) {
  form.delete(route('favorite-repos.destroy', item.id), {
      onSuccess: () => {
          alert("Repo was removed from your favorites successfully");
      },
      onError: (errors) => {
          alert("There was an error while trying to remove the repo from your favorites");
      },
  });
}

</script>

<template>
    <Head title="Favorite Repos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Favorite Repos
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                  <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                  <PaginationTable 
                      :headers="tableHeaders" 
                      :items="props.favoriteRepos"
                      :page="props.page"
                      :itemsPerPage="perPage"
                      :itemsTotal=props.total
                      @pageChange="handlePageChange"
                      @actionHandler="removeFavoriteRepo"
                      >
                  </PaginationTable>
                  </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>