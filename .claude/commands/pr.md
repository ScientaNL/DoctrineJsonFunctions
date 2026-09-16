---
description: Commit, push to origin and open a prefilled PR form in the browser.
---

# Open a PR

Commit message and PR body follow the [writing skill](../skills/writing/SKILL.md). Shortest version that works: subject line only unless the why isn't in the diff.

Never `gh pr create` without `--web`. This command stops at the prefilled form; the user reviews the diff there and creates the PR. That is how [CLAUDE.md § Running commands](../../CLAUDE.md#running-commands) ("always ask before opening a PR") is satisfied.

## Steps

1. `git status` + `git diff` (staged and unstaged) + `git log upstream/master..HEAD`, see what's actually going in.
2. On `master`? Branch first.
3. Uncommitted work → stage it and commit. One subject line, imperative, no body unless the why is non-obvious; issue ref as the last line, same form as the [body](#body). Run the checks the [CLAUDE.md § After making changes](../../CLAUDE.md#after-making-changes) table requires for what you changed. Never `--no-verify`.
4. `git push origin HEAD`, per [CLAUDE.md § Running commands](../../CLAUDE.md#running-commands).
5. Open the prefilled form, `<fork-owner>` from `git remote -v`:
   ```bash
   gh pr create --web --repo ScientaNL/DoctrineJsonFunctions --base master --head <fork-owner>:<branch> \
     --title "<title>" --body "<body>" --assignee @me --label <labels>
   ```
   - Labels ([Labels](#labels)) comma-separated; none → drop the flag.
   - `/pr draft` → say to tick draft in the form.
6. Print the title, body and labels as plain text.

## Labels

Exact names as `gh label list --repo ScientaNL/DoctrineJsonFunctions` prints them. Only the category, straight from the diff; say which one you prefilled:

| Label | Applies when |
|---|---|
| `bug` | fixes broken behaviour, usually with the failing test that proved it |
| `enhancement` | adds a function node, a platform or a capability that did not exist |
| `testing` | test-only change, no production behaviour changed |

None of them fits, or two plausibly do → leave it out and mention it, don't guess.

Never prefill `sidequest :compass:`; that one is set in the form.

## Body

One or two lines: what changed and why. Bullets only when there's more than one thing. No headers, no restating the diff, no test plan, no AI attribution.

A change touching a platform-specific node says which platforms it was proven on, because a reviewer cannot tell from the diff which integration suites ran.

Multiple commits → the body is roughly the commit subjects. Single commit → the body can just repeat it.

Issue ref, when there is one, on its own last line: `Fixes #138`.

Leave the human note slot empty. Never write anything below a `---`; that slot is the author's to write.

## Editing an existing PR

`gh pr view <n> --repo ScientaNL/DoctrineJsonFunctions --json body` first, keep everything from the last `---` onward verbatim, rewrite only above it.

Draft toggle on an open PR: `gh pr ready <n> --repo ScientaNL/DoctrineJsonFunctions --undo` to make it a draft, `gh pr ready <n> --repo ScientaNL/DoctrineJsonFunctions` to undraft.
