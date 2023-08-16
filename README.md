# Create sveltekit + php backend without nodejs.


## Building sveltekit app

To create a production version of your app:

```bash
npm run build
```

## php files with changes

```
.htaccess
index.php - main entry point
backaned/ - phpData sources for pages
backaned/routes.php - dynamic routes regexp.
svelte.config.js - dynamic routes regexp
src/app.html - section with dyanamic window.phpData for SSR.
```
use index.php for php or autoload classes.
You can use backend path for routes and return data from backend (see index.php and svelte.config.js)
