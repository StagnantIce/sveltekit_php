<script lang="ts">
    import { onMount } from 'svelte';
    import Child from './child.svelte';
    export let title = '%phpData.title%';

    export let posts = [];
    onMount(() => {
        title = window.phpData['title'];
        posts = window.phpData['posts'];
    })
</script>

<h1>{title}</h1>

{#if posts.length}
    {#each posts as post}
        <Child { ...post}/>
    {/each}
{:else}
    {#each Array(4) as _, index}
        <Child title="%phpData.posts[{index}].title%" text="%phpData.posts[{index}].text%"/>
    {/each}
{/if}
