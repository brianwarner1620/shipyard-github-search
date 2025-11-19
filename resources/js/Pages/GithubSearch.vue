<script setup lang="ts">
import { ref, watch, computed, reactive } from 'vue';

import { useForm } from '@inertiajs/vue3';
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
    { title: 'Actions', key: 'actions', value: 'actions' }
];

const form = useForm({
  repo_id: '',
  name: '',
  owner: '',
  html_url: '',
  description: '',
  stargazers_count: ''
});

const search = ref('');
const sort = ref('stars');
const order = ref('desc');
const perPage = ref(15);
const currentPage = ref(1);

const favoritedReposList = ref([]);

const props = defineProps({
  repositories: Object,
  favoriteReposIds: Array,
  page: Number
});

function saveFavoritedReposList() {
  favoritedReposList.value = props.favoriteReposIds;
}

const isFavorited = (item) => {
    if (favoritedReposList.value) {
        return favoritedReposList.value.includes(item.id) ? 'delete' : 'add';
    } 
}

function handlePageChange(newPage) {
  currentPage.value = newPage;
  Inertia.reload({
    only: ['repositories', 'page', 'favoriteRepoIds'],
    data: {
      page: newPage
    }
  });
}

function searchRepositories() {
  Inertia.get(route('github.search'), { searchTerm: search.value, sort: sort.value, order: order.value, perPage: perPage.value, page: 1 }, {
    preserveState: true,
    replace: true,
  });
}

function addFavoriteRepo(item) {
  form.repo_id = item.id;
  form.name = item.name;
  form.owner = item.owner.login;
  form.html_url = item.html_url;
  form.description = item.description;
  form.stargazers_count = item.stargazers_count;

  form.post(route('favorite-repos.store'), {
      onSuccess: () => {
          handlePageChange(props.page);
          alert('Repo was added to your favorites');
      },
      onError: (errors) => {
          alert('There was an error adding the repo to your favorites');
      },
  });
}

function removeFavoriteRepo(item) {
  form.delete(route('favorite-repos.destroy', item.id), {
      onSuccess: () => {
          handlePageChange(props.page);
          alert("Repo was removed from your favorites successfully");
      },
      onError: (errors) => {
          alert("There was an error while trying to remove the repo from your favorites");
      },
  });
}

saveFavoritedReposList();
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
                  
                 </div>
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                  <PaginationTable 
                      :headers="tableHeaders" 
                      :items="props.repositories.items"
                      :page="props.page"
                      :itemsPerPage="perPage"
                      :itemsTotal="props.repositories.total_count"
                      :renderActionButton="isFavorited"
                      addButton="mdi-plus"
                      deleteButton="mdi-delete"
                      @pageChange="handlePageChange"
                      @addHandler="addFavoriteRepo"
                      @removeHandler="removeFavoriteRepo"
                  >
                  </PaginationTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>