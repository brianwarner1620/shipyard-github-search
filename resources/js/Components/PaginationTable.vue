<script setup lang="ts">
  import { ref, computed, watch, defineEmits } from 'vue';

  const emit = defineEmits(['pageChange', 'actionHandler'])

  const props = defineProps<{
    headers: any;
    items: any;
    page: number;
    itemsPerPage: number;
    itemsTotal: number;
}>();

const currentPage = ref(props.page);
const pageCount = computed(() => Math.ceil(props.itemsTotal / props.itemsPerPage));

function pageChange(newPage) {
    currentPage.value = newPage;
    emit('pageChange', newPage);
}

function clickHandler(item) {
    emit('actionHandler', item);
}
</script>


<template>
  <v-data-table
    :headers="headers"
    :items="items"
    :items-per-page="itemsPerPage"
  >
    <template v-slot:item.actions="{ item }">
        <v-btn small icon @click="clickHandler(item)">
          <v-icon>mdi-delete</v-icon>
        </v-btn>
    </template>
    <template v-slot:top>
      <v-pagination
        v-model="currentPage"
        :length="pageCount"
        @update:modelValue="pageChange"
      ></v-pagination>
    </template>
  </v-data-table>
</template>