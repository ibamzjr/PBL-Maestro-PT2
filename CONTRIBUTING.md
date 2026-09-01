# Contributing

Contributions that strengthen the educational value of PBL Maestro PT2 are
welcome.

## Workflow

1. Open an issue that defines the problem, intended behavior, and scope.
2. Create a focused branch from `main`.
3. Keep interface changes consistent with the existing Blade and Tailwind
   structure.
4. Never commit `.env`, databases, credentials, logs, sessions, or user uploads.
5. Run the available checks before opening a pull request.

```bash
composer install
npm install
php artisan test
npm run build
```

Pull requests should describe the user impact, validation performed, data-model
changes, security implications, and any remaining limitations.
