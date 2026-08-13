<div align="center">
    <h1>GitHub Workflow</h1>
</div>

<p align="center">
    <a href="https://packagist.org/packages/hamforge/boost-github-workflow"><img src="https://img.shields.io/packagist/v/hamforge/boost-github-workflow.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://github.com/hamforge/boost-github-workflow/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/hamforge/boost-github-workflow/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/hamforge/boost-github-workflow"><img src="https://img.shields.io/packagist/dt/hamforge/boost-github-workflow.svg?style=flat-square" alt="Total Downloads"></a>
</p>

hamforge's opinionated GitHub workflow for AI-assisted Laravel development, distributed as Laravel Boost skills.

It gives coding agents a consistent way to capture ideas, plan work, investigate and implement issues, create pull requests, and review releases without turning the package into a runtime GitHub integration.

Built and maintained independently by [hamforge](https://hamforge.dev) in Australia.

## What You Get

After installation, supported AI coding assistants gain access to the bundled GitHub workflow for capturing ideas, planning work, selecting and implementing issues, creating pull requests, and reviewing release readiness.

## Installation

The package provides development-time workflow guidance rather than runtime application behavior, so install it in an existing Laravel Boost application as a development dependency:

```bash
composer require --dev hamforge/boost-github-workflow
```

Then ask Laravel Boost to discover the newly installed package and make its skills available to your configured AI coding assistants:

```bash
php artisan boost:update --discover
```

If Laravel Boost is not configured yet, install it and run its initial setup instead:

```bash
composer require laravel/boost --dev
php artisan boost:install
```

After the skills have been installed, normal `php artisan boost:update` runs keep the existing Boost resources current.

## Prerequisites

GitHub-interacting skills use [GitHub CLI](https://cli.github.com/) as their standard interface. Install `gh` and authenticate it before use:

```bash
gh auth login
```

## Conventions

By default, the package assumes the following workflow conventions:

- `priority:current` for the immediate working set
- `status:parking-lot` for unscheduled ideas
- milestones as the default representation of planned releases
- issues for planned work, pull requests for reviewed changes, and changelogs for shipped outcomes

Explicit project-specific workflow instructions may override these hamforge defaults.

## Skills

| Skill | Purpose |
| --- | --- |
| `$github-workflow` | Explain the workflow and route to a focused skill |
| `$github-capture-idea` | Capture an unscheduled idea |
| `$github-create-issue` | Create one scoped issue |
| `$github-plan-roadmap` | Plan larger or multi-issue work |
| `$github-next-issue` | Recommend exactly one next issue |
| `$github-investigate-issue` | Investigate an issue before implementation |
| `$github-implement-issue` | Implement one selected issue |
| `$github-create-pull-request` | Create a pull request for completed issue work |
| `$github-release-review` | Review release readiness without changing state |

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Thank you for considering contributing to GitHub Workflow! Please review our [contributing guide](.github/CONTRIBUTING.md) to get started.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [hamforge](https://github.com/hamforge)
- [All Contributors](../../contributors)

## License

GitHub Workflow is open-sourced software licensed under the [MIT license](LICENSE.md).
