# newspack-hp-redirect-fix

Patches a redirect loop that will occur in hosted Newspack sites when the homepage is requested with a query parameter whose value includes a space. Example:

```
curl -LI https://mynewspacksite.com/?utm_source=two+words
```