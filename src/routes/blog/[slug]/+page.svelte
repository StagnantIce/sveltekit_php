<script lang="ts">
    import { onMount } from 'svelte';
    
    const title = '%phpData.title%';

    onMount(() => {
        title = window.pageData['title'];
    })
</script>

{title}
