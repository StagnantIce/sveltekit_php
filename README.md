# Create sveltekit + php backend without nodejs.

Usefull, if you like sveltekit, but dont have hosting with nodejs.


## SvelteKit: Building app in build folder.

To create a production version of your app:

```bash
npm run build
```

## PHP: which files has changes?

```
.htaccess
index.php - main entry point
backend/ - phpData sources for pages, each page has $request array param and can have %phpData...% for dynamic SSR data.
backend/routes.php - dynamic routes regexp.
svelte.config.js - dynamic routes regexp and adpater-static set.
src/app.html - section with dynamic window.phpData for hydration.
```
use index.php for php or autoload classes.
You can use backend path for routes and return data from backend (see index.php and svelte.config.js)
