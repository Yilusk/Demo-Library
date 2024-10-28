<template>
  <div v-if="links.length > 3" class=" flex justify-center">
    <div class="flex flex-wrap ">
      <template v-for="(link, key) in links">
        <div v-if="link.url === null" :key="key" class="mb-1 mr-1 px-4 py-3 text-gray-400 text-lg leading-4  rounded"
          v-html="makeLabel(link.label)" />
        <Link v-else :key="`link-${key}`"
          class="mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-lg text-slate-600 leading-4 hover:bg-white focus:border-indigo-500 rounded"
          :class="{ 'bg-indigo-100 rounded-full': link.active }" :href="link.url" v-html="makeLabel(link.label)" />
      </template>
      <p class="text-slate-500 pt-3">
        Showing {{ paginator.from }} to {{ paginator.to }} of {{ paginator.total }} results
      </p>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  links: Array,
  paginator: Object
})

const makeLabel = (label) => {
  if (label.includes('Previous')) {
    return '<<'
  } else if (label.includes('Next')) {
    return '>>'
  } else {
    return label
  }
}

const activeClass = () => {

  return 'mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-lg text-slate-600 leading-4 hover:bg-white focus:border-indigo-500 rounded'

}

</script>