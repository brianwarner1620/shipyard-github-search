<script setup lang="ts">
  import { ref, computed, watch, defineEmits } from 'vue';

  const emit = defineEmits(['pageChange'])

  const props = defineProps<{
    headers: any;
    items: any;
    page: number;
    itemsPerPage: number;
    itemsTotal: number;
}>();

const currentPage = ref(props.page);
const pageCount = computed(() => Math.ceil(props.itemsTotal / props.itemsPerPage));

  /*const headers = [
    { title: 'Dessert (100g serving)', key: 'name' },
    { title: 'Calories', key: 'calories' },
    { title: 'Fat (g)', key: 'fat' },
    { title: 'Carbs (g)', key: 'carbs' },
    { title: 'Protein (g)', key: 'protein' },
  ];*/

  const desserts = [
    {
      name: 'Frozen Yogurt',
      calories: 159,
      fat: 6.0,
      carbs: 24,
      protein: 4.0,
    },
    // ... more items
  ];

watch(currentPage, (newValue) => {
  emit('pageChange', newValue);
  });

</script>


<template>
  <v-data-table
    :headers="headers"
    :items="items"
    :items-per-page="itemsPerPage"
    class="elevation-1"
  >
    <template v-slot:bottom>
      <v-pagination
        v-model="currentPage"
        :length="pageCount"
      ></v-pagination>
    </template>
  </v-data-table>
</template>