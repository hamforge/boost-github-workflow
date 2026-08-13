---
name: github-create-pull-request
description: >
  Turn completed work for one numbered GitHub issue into a focused pull request.
  Use to review the diff, prepare and push the working branch, run required
  checks, and create the pull request without merging it.
license: MIT
metadata:
  author: hamforge
---

# GitHub Create Pull Request

Require an issue number. Invoking this skill authorizes the normal mechanics needed to create one pull request for that issue: safely creating or reusing a working branch, committing only the issue's scoped changes when needed, pushing that branch, and creating the pull request. It does not authorize rewriting history, merging, closing unrelated issues, changing roadmap state, or publishing a release.

## GitHub Prerequisite

Verify `gh` is installed, confirm authentication with `gh auth status`, resolve the repository and default branch from the working checkout with `gh repo view`, then read the complete issue with `gh issue view`. Confirm the issue exists and is open. Use first-class `gh` commands unless `gh api` is genuinely required. If access fails, report the prerequisite and stop rather than switching interfaces.

## Before Mutating

1. Read the issue's complete goal, context, scope, acceptance criteria, exclusions, dependencies, and verification requirements.
2. Read repository instructions and the shared contribution guidance when available.
3. Inspect the current branch, upstream, working-tree status, staged and unstaged changes, commits relative to the default branch, and the complete diff.
4. Check for an existing pull request from the current or intended working branch and for other pull requests that already implement the issue.
5. Locate an existing pull-request template and determine the repository's required checks, PR title convention, and issue-linking convention.
6. Confirm every change and commit belongs to the selected issue and that its dependencies are resolved.

If an equivalent pull request already exists, do not modify it or create another. Return its number, title, state, branch, and URL.

Stop before pushing or creating a pull request when the issue is blocked, the diff contains unrelated changes that cannot be safely isolated, required work remains incomplete, required checks fail, the repository is in the middle of another Git operation, or branch state cannot be handled without rewriting history.

## Prepare the Branch

- Never create a pull request from the repository's default branch or detached HEAD.
- Reuse the current non-default branch when its commits and changes belong only to the issue.
- When completed issue work is safely present on the default branch as uncommitted changes, create an appropriate local working branch before committing it.
- Follow an established branch naming convention when one exists. Otherwise use a short descriptive name; include the issue number only when the repository convention does so.
- Stage and commit only files belonging to the selected issue. Follow the existing commit convention or use a concise imperative subject.
- Do not amend, squash, rebase, reset, force-push, or alter existing shared commits without separate authorization.
- Run all repository-required checks before pushing. Report failures accurately and stop without creating the pull request.
- Push the working branch with its upstream when needed. Never force-push.

## Create the Pull Request

Review the final branch diff and commits against the default branch immediately before creation. Use `gh pr create` with the resolved base and head branches.

Use the repository's pull-request template when present. Preserve its required sections and complete them with factual information. When no template exists, include:

```markdown
## Summary

## Verification

Closes #123
```

Link the selected issue using the repository's established convention. Use a closing keyword only when merging this pull request should close the issue. Create a draft only when explicitly requested or required by repository instructions.

## Return

Report:

- **Pull Request** — number, title, and URL
- **Issue** — linked issue number and title
- **Branches** — head and base branches
- **Commits** — commits included in the pull request
- **Scope** — concise summary of the completed issue work
- **Verification** — commands run and results
- **Deliberately Excluded** — unrelated changes left out, when applicable
- **Next Step** — review and merge remain separate actions

Do not merge or auto-merge the pull request, close the issue manually, alter labels or milestones, publish a release, or begin unrelated work.

## Anti-patterns

- creating a pull request before reviewing the complete diff and commits
- including unrelated working-tree changes or commits
- pushing the default branch or rewriting shared history
- creating a duplicate pull request
- hiding failed or skipped checks
- treating pull-request creation as authorization to merge or release
