---
description: Rebase a PR on master, fix the easy red, ask about the rest, amend, force-push, watch CI until green.
---

# Get a PR green

`/green <pr-url|number>`, or no argument for the current branch's PR.

Mechanical only. Never posts a comment, never re-requests a review, never opens or merges a PR. Review threads are [/resolve](resolve.md).

## Steps

1. `gh pr view <n> --repo ScientaNL/DoctrineJsonFunctions --json headRefName,headRepositoryOwner,url,title,mergeable,statusCheckRollup`. Head owner is not `gh api user --jq .login` → stop, it's someone else's branch to force-push.
2. On the branch already? Stay. Otherwise `git fetch origin <headRefName> && git switch <headRefName>`. Dirty tree → stop and show it.
3. `git fetch upstream master && git rebase upstream/master`. Conflicts: resolve them, never `git merge`. A conflict whose resolution picks a behaviour is a judgement call, see [Easy or a judgement call](#easy-or-a-judgement-call).
4. Fix what's red, easy ones only:
   - Failed checks from step 1 → `gh run view <run-id> --repo ScientaNL/DoctrineJsonFunctions --log-failed` for each, and read the whole log rather than grepping it.
   - A failure naming a test absent from the working tree came from `master`. Still yours to fix; say so in the report.
   - The CI matrix runs combinations your machine does not: a job green locally can be red on another PHP version, DBAL or ORM major, or platform. Read which matrix leg failed before concluding the fix is wrong ([CLAUDE.md § The support matrix](../../CLAUDE.md#the-support-matrix-decides-most-questions)).
   - An integration leg needs its server: `docker-compose.yml`, then that platform's suite.
   - Run the checks the [CLAUDE.md § After making changes](../../CLAUDE.md#after-making-changes) table requires before pushing.
5. Amend into the commit that owns the change; never a "fix review" or "fix CI" commit. The subject still describes the change after amending; if it no longer does, rewrite it. Splitting or reordering commits: only when asked.
6. `git push --force-with-lease`.
7. Watch with the Monitor tool over `gh pr checks <n> --repo ScientaNL/DoctrineJsonFunctions --watch --interval 60`, event on each failure and on completion. A failure lands → back to step 4, amend, push, keep watching.
8. Report: what was rebased onto, what was fixed, final check state.

## Easy or a judgement call

Easy is a forced fix, yours without asking: one way to make the check pass, and it doesn't change what the code does.

A judgement call is a fix that picks a behaviour, where more than one answer is defensible → `AskUserQuestion`, four at a time, each carrying the failing output and the code as it stands. Options are real positions, never `fix it / skip it`.

Widening a version constraint, dropping a matrix leg, or changing what SQL a node emits to satisfy one platform is always a judgement call.

Unsure which it is → a judgement call.

## Stop instead of pushing again

- The same job failed twice on the same fix. Report the log, don't try a third.
- `--force-with-lease` is rejected, someone else pushed. Show `git log` of both sides, don't overwrite.

## Verify before reporting green

A check that went green because the test stopped testing is not fixed. For each fix, state the mechanism: what was broken, what now makes it pass. Silencing a linter, adding a suppression, or deleting an assertion is a judgement call, not a fix; suppressions go through [code-quality.md § Suppression Policy](../rules/code-quality.md#suppression-policy).
