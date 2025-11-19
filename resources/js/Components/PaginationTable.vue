<script setup lang="ts">
  import { ref, computed, watch, defineEmits } from 'vue';

  const emit = defineEmits(['pageChange', 'addHandler', 'removeHandler'])

  const props = defineProps<{
    headers: any;
    items: any;
    page: number;
    itemsPerPage: number;
    itemsTotal: number;
    renderActionButton: Function;
    addButton: string;
    deleteButton: string;
}>();

const currentPage = ref(props.page);
const pageCount = computed(() => Math.ceil(props.itemsTotal / props.itemsPerPage));

function pageChange(newPage) {
    currentPage.value = newPage;
    emit('pageChange', newPage);
}

function clickAddHandler(item) {
    emit('addHandler', item);
}
function clickRemoveHandler(item) {
    emit('removeHandler', item);
}
function canDisplayButton(item) {
  return props.renderActionButton(item);
}
</script>


<template>
  <v-data-table
    :headers="headers"
    :items="items"
    :items-per-page="itemsPerPage"
  >
    <template v-slot:item.actions="{ item }">
        <v-btn v-if="canDisplayButton(item) === 'add'" small icon @click="clickAddHandler(item)">
          <v-icon>{{ props.addButton }}</v-icon>
        </v-btn>
        <v-btn v-if="canDisplayButton(item) === 'delete'" small icon @click="clickRemoveHandler(item)">
          <v-icon>{{ props.deleteButton }}</v-icon>
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