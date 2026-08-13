---
name: github-workflow
description: >
  Explain and route hamforge's GitHub-native idea, roadmap, issue,
  implementation, pull-request, and release workflows without changing state.
  Use when the appropriate focused GitHub skill is unclear or when returning
  to a project.
license: MIT
metadata:
  author: hamforge
---

# GitHub Workflow

This is the read-only manual and router for hamforge's GitHub workflow. Explicit project instructions override these defaults.

Do not change files or GitHub state. Inspect repository guidance and live GitHub state with authenticated `gh` only when useful for routing.

## Workflow Model

```text
Milestone (planned release)
    -> Issue (planned work)
    -> Implementation
    -> Pull request creation
    -> Pull request (reviewed change)
    -> Merge
    -> Changelog (shipped outcome)
```

- `priority:current` identifies current work candidates.
- `status:parking-lot` identifies unscheduled ideas; these normally have no milestone and never also carry `priority:current`.
- issue creation, idea capture, investigation, and work selection do not authorize implementation.

## Choose the Workflow

### I have a loose idea

Use `$github-capture-idea` to save it in the Parking Lot without scheduling or implementing it.

### I have concrete work to capture

Use `$github-create-issue` to check for duplicates and create one scoped, actionable issue. Issue creation does not start implementation.

### I need to plan several related issues

Use `$github-plan-roadmap`. Its first pass proposes issue and milestone changes without mutating GitHub; an approved apply phase performs only the agreed changes.

### I want to know what to work on next

Use `$github-next-issue` to inspect current priorities, dependencies, blockers, and pull requests, then recommend exactly one issue.

### I need to investigate an issue

Use `$github-investigate-issue` for a numbered issue with unresolved behavior, architecture, risk, or decisions. Investigation does not implement code.

### I am ready to implement an issue

Use `$github-implement-issue` for one understood, unblocked numbered issue. It implements only that scope and does not create a pull request or close the issue by default.

### I have completed issue work to submit for review

Use `$github-create-pull-request` for one numbered issue. It reviews the completed diff and commits, prepares and pushes a safe working branch, runs required checks, and creates one linked pull request without merging it.

### I want to review release readiness

Use `$github-release-review` for a read-only assessment of scope, work, checks, release notes, compatibility, and risks.

## Routing Table

| Intent | Skill |
| --- | --- |
| Save a loose, unscheduled idea | `$github-capture-idea` |
| Create one actionable issue | `$github-create-issue` |
| Plan a larger or multi-issue direction | `$github-plan-roadmap` |
| Recommend what to work on next | `$github-next-issue` |
| Investigate a numbered issue | `$github-investigate-issue` |
| Implement an understood numbered issue | `$github-implement-issue` |
| Create a pull request for completed issue work | `$github-create-pull-request` |
| Assess release readiness | `$github-release-review` |

## Quick Reference

| Skill | GitHub writes | Code writes | Additional approval required | Purpose |
| --- | --- | --- | --- | --- |
| `$github-workflow` | No | No | Not applicable | Explain and route the workflow |
| `$github-capture-idea` | Creates one issue | No | No; invocation authorizes capture | Save an unscheduled idea |
| `$github-create-issue` | Creates one issue | No | No; invocation authorizes creation | Create scoped actionable work |
| `$github-plan-roadmap` | Apply phase only | No | Yes; approve the proposal first | Plan related roadmap work |
| `$github-next-issue` | No | No | Not applicable | Recommend exactly one next issue |
| `$github-investigate-issue` | No | No | Not applicable | Investigate without implementation |
| `$github-implement-issue` | No by default | Yes | No; invocation authorizes scoped implementation | Implement one issue |
| `$github-create-pull-request` | Pushes one branch and creates one pull request | No | No; invocation authorizes PR preparation and creation | Submit completed issue work for review |
| `$github-release-review` | No | No | Not applicable | Assess release readiness |

Do not imply every issue needs investigation. Use it for unclear behavior, meaningful risk, architecture choices, permissions, external integrations, infrastructure, or substantial data changes.

When the request sits between workflows, explain the distinction and recommend exactly one next skill. Do not invoke that skill automatically. End with an exact copyable invocation.

## GitHub Access

Focused skills that need live GitHub state use GitHub CLI as the standard interface. They verify `gh` availability and authentication, then resolve the repository from the working checkout with `gh repo view`; no repository name is hard-coded.

If `gh` is unavailable, unauthenticated, or cannot access the repository, report the prerequisite without switching interfaces. Continue only when the workflow permits local-only work.

## References

Read only when the routing question needs more doctrine:

- `references/contributions.md`
- `references/issues-and-labels.md`
- `references/maintenance-and-releases.md`

## Anti-patterns

- running another workflow instead of routing to it
- treating a selected or created issue as implementation authorization
- inventing an alternate label taxonomy when a hamforge workflow label is missing
- hard-coding a repository, changelog path, product-document path, or release date
- silently expanding one authorized action into another
