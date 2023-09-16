# Create sveltekit + php backend without nodejs.

Usefull, if you like sveltekit, but dont have hosting with nodejs.

Example: /backend/blog/[slug].php


## SvelteKit: Building app in build folder.

To create a production version of your app:

```bash
npm run build
```

## PHP: which files has changes?

```
.htaccess
index.php - main entry point
backend/ - phpData sources for pages, each page has $request array param and can have %phpData...% for dynamic SSR data. (see /backend/blog/[slug].php)
backend/routes.php - dynamic routes regexp.
svelte.config.js - dynamic routes regexp and adpater-static set.
src/app.html - section with dynamic window.phpData for hydration.
```
use index.php for php or autoload classes.
You can use backend path for routes and return data from backend (see index.php and svelte.config.js)


## PHP: Can I use php tags in svelte files?

Yes, its possible, example:

``
<script lang="ts">
    import { Demo } from '$lib/demo';
    import { Site } from '$lib/site';
    import { browser } from '$app/environment';
</script>

{#if browser}
    {#if window.phpData.site.id === 1}
        <Demo/>
    {:else}
        <Site/>
    {/if}
{:else}
    {@html '<!--<?php if ($phpData["site"]["id"] === 1) {?>-->'}
        <Demo/>
    {@html '<!--<?php } else { ?>-->'}
        <Site/>
    {@html '<!--<?php } ?>-->'}
{/if}
```
