<script lang="ts">
    import { onMount } from 'svelte';
    
    let ssrTitle = '%phpData.title%';

    onMount(() => {
        ssrTitle = window.pageData['title'];
    })
</script>

{ssrTitle}
