<template>
  <nav v-if="totalPages > 1" aria-label="Pagination">
    <ul :class="paginationClasses">
      <!-- Previous Button -->
      <li class="page-item" :class="{ disabled: currentPage === 1 }">
        <a
          class="page-link"
          href="#"
          aria-label="Previous"
          @click.prevent="changePage(currentPage - 1)"
        >
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <!-- First Page -->
      <li v-if="showFirstLast && currentPage > 3" class="page-item">
        <a class="page-link" href="#" @click.prevent="changePage(1)">1</a>
      </li>

      <!-- Ellipsis -->
      <li v-if="showFirstLast && currentPage > 4" class="page-item disabled">
        <span class="page-link">...</span>
      </li>

      <!-- Page Numbers -->
      <li
        v-for="page in visiblePages"
        :key="page"
        class="page-item"
        :class="{ active: page === currentPage }"
      >
        <a class="page-link" href="#" @click.prevent="changePage(page)">
          {{ page }}
        </a>
      </li>

      <!-- Ellipsis -->
      <li v-if="showFirstLast && currentPage < totalPages - 3" class="page-item disabled">
        <span class="page-link">...</span>
      </li>

      <!-- Last Page -->
      <li v-if="showFirstLast && currentPage < totalPages - 2" class="page-item">
        <a class="page-link" href="#" @click.prevent="changePage(totalPages)">
          {{ totalPages }}
        </a>
      </li>

      <!-- Next Button -->
      <li class="page-item" :class="{ disabled: currentPage === totalPages }">
        <a
          class="page-link"
          href="#"
          aria-label="Next"
          @click.prevent="changePage(currentPage + 1)"
        >
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  currentPage: { type: Number, required: true },
  totalPages: { type: Number, required: true },
  maxVisiblePages: { type: Number, default: 5 },
  size: { type: String, default: 'md' }, // sm, md, lg
  showFirstLast: { type: Boolean, default: true }
});

const emit = defineEmits(['update:currentPage', 'change']);

const paginationClasses = computed(() => {
  const classes = ['pagination'];

  if (props.size === 'sm') {
    classes.push('pagination-sm');
  } else if (props.size === 'lg') {
    classes.push('pagination-lg');
  }

  return classes.join(' ');
});

const visiblePages = computed(() => {
  const pages = [];
  const half = Math.floor(props.maxVisiblePages / 2);

  let start = Math.max(1, props.currentPage - half);
  let end = Math.min(props.totalPages, start + props.maxVisiblePages - 1);

  // Adjust start if we're near the end
  if (end - start < props.maxVisiblePages - 1) {
    start = Math.max(1, end - props.maxVisiblePages + 1);
  }

  for (let i = start; i <= end; i++) {
    pages.push(i);
  }

  return pages;
});

const changePage = (page) => {
  if (page < 1 || page > props.totalPages || page === props.currentPage) {
    return;
  }

  emit('update:currentPage', page);
  emit('change', page);
};
</script>
