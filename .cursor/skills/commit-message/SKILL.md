---
name: commit-message
description: Generate conventional commit messages by analyzing staged git changes. Use when the user asks for a commit message, wants to commit staged changes, or says "commit message", "suggest commit", or "what should I commit".
---

# Commit Message from Staged Changes

## When to Activate

Apply this skill when the user:
- Asks for a commit message
- Wants help committing staged changes
- Says "suggest commit", "commit message", "what should I commit", or similar

## Workflow

1. **Get staged diff**: Run `git diff --staged` to see what's staged.
2. **Analyze changes**: Identify added/modified/deleted files, new features, fixes, refactors, config updates.
3. **Generate message**: Use [Conventional Commits](https://www.conventionalcommits.org/) format.

## Commit Message Format

```
<type>(<scope>): <short description>

[optional body - wrap at 72 chars]
```

**Types**: `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`, `perf`, `ci`, `build`

**Scope**: Optional. Use when change is scoped (e.g. `filament`, `auth`, `ui`).

## Guidelines

- **Short description**: Imperative mood, ~50 chars, no period. "Add X" not "Added X".
- **Body**: Optional. Use for non-obvious changes, breaking changes, or multiple logical changes.
- **One logical change per commit**: If the diff mixes unrelated changes, suggest splitting or note it.

## Output

Provide the commit message in a copyable block. Optionally suggest: `git commit -m "..."` with the message.
