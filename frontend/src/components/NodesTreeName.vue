<template>
    <span class="tree">
        <span>...</span>
        <i class="fa fa-random text-muted"></i>
        <span class=" badge alert-success" style="font-size: 12px">
             {{ nodeName }}
        </span>
        <i class="fa fa-random text-muted"></i>
        <span>...</span>
    </span>
</template>

<script>

export default {
  name: 'NodesTreeName',
  props: ['nodeName'],
}
</script>