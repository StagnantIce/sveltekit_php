<script lang="ts">
    import { onMount } from 'svelte';
    export let title = '%phpData.title%';

    onMount(() => {
        title = window.pageData['title'];
    })
</script>

{title}
