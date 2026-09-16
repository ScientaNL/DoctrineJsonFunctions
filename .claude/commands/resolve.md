---
description: Assess a PR's review threads, apply what's accepted, ask about the rest, draft replies.
---

# Resolve review feedback

`/resolve <pr-url|number>`. A `#discussion_r<id>` or `#pullrequestreview-<id>` anchor narrows it to that thread or review.

Resolve means working through the review feedback, not GitHub's resolve-conversation button; marking threads resolved stays the reviewer's ([After posting](#after-posting)).

Nothing is posted without a separate go. Pushing code is fine (own branch, `--force-with-lease`); posting a comment, resolving a thread and re-requesting a review are not. This is a public repository, so every reply is read by people with no context from the session.

## Fetch

```bash
gh api graphql -f query='
query($owner:String!,$repo:String!,$num:Int!){
  repository(owner:$owner,name:$repo){ pullRequest(number:$num){
    headRefName headRepositoryOwner{login}
    reviewThreads(first:100){ nodes{ isResolved isOutdated
      comments(first:20){ nodes{ author{login} body path line url } } } } } } }
' -F owner=ScientaNL -F repo=DoctrineJsonFunctions -F num=<n>
```

Plus `gh pr view <n> --repo ScientaNL/DoctrineJsonFunctions --json reviews,comments` for review-level bodies that aren't anchored to a line.

Skip `isResolved`. Keep `isOutdated`: the code moved, the point may still stand. A thread whose last comment is our own (`gh api user --jq .login`) is already answered; don't re-answer it.

## Sort

Read the code at each thread before judging it, not just the diff. Then a numbered list, one line each: `<n>. <path>:<line>, <what they want> → apply | discuss | reject | issue`. Numbering is how the user steers ("fix 1, respond to 2"), so keep it stable for the rest of the turn.

- **apply**: concrete and correct, no behaviour decision in it.
- **discuss**: a real question, a design call, or you think they're wrong.
- **reject**: factually wrong about the code, and you can prove it with the code.
- **issue**: fair, and belongs in other work, filed now and not promised (below).

A reviewer's `suggestion` block is still a claim, not an instruction. It's `apply` only when it's right.

A claim about what a platform accepts, or about a Doctrine API, is checked against that platform or the installed package before it is sorted, never from memory ([review-standards](../skills/review-standards/SKILL.md)).

## Apply

Apply the `apply` set, amend into the commit that owns each change, run the checks the [CLAUDE.md § After making changes](../../CLAUDE.md#after-making-changes) table requires, push `--force-with-lease`.

Then verify each one landed, by the reviewer's own claim, not by your edit succeeding:

- "this emits the wrong SQL" → run the unit test, show the generated string.
- "this breaks on Postgres" → run that integration suite, show it pass.
- "these tests don't cover X" → run the test, show it fails without the fix.

A claim you can't re-prove moves to `discuss`. Do not report an item applied on the strength of having made the edit.

## Ask about the rest

One `AskUserQuestion` per remaining finding, batched four at a time. Each question carries the full context so the PR never has to be opened:

- The reviewer's comment verbatim.
- The code as it stands, with the path and line.
- Your read: is it right, what breaks if applied, what breaks if not.
- Options as real positions ("apply as suggested", "counter with X", "reject, the platform validation already guarantees it"), not "yes / no".

## Replies

Draft, show, stop. Post only on an explicit go.

**A thread you applied as asked, with nothing to add, gets a 👍 and no reply.** Reply only where the reviewer learns something: you deviated, you pushed back, you applied it somewhere they didn't name, or you're asking them something.

```bash
gh api -X POST repos/ScientaNL/DoctrineJsonFunctions/pulls/comments/<id>/reactions -f content=+1
```

- Reactions take no footer line, and wait for the same go as a reply.
- List them separately from the written replies in the draft.

Written replies:

- English, the language the project's issues and reviews are written in. Register and the tells to avoid: [writing skill](../skills/writing/SKILL.md).
- Say what changed and why. Nothing about mechanics: no rebasing, no amending, no "good catch", no restating their comment back at them.
- One or two sentences. A reject states the fact that refutes it and where to see it.

Post a threaded reply with the comment id from the thread URL's `#discussion_r<id>`:

```bash
gh api repos/ScientaNL/DoctrineJsonFunctions/pulls/<n>/comments/<id>/replies -f body="$reply"
```

## Out of scope: file the issue, don't promise it

A thread that is fair but belongs in other work gets an issue **now**, before the reply is drafted, so the reply carries the number. "We'll open an issue for this" is a promise nobody is holding, and the issue is the only part the reviewer cannot check for themselves.

Search first, so a retry cannot file a second one:

```bash
gh issue list --repo ScientaNL/DoctrineJsonFunctions --state all --search "<the thread's own URL>"
gh issue create --repo ScientaNL/DoctrineJsonFunctions --title "<title>" --body "<body>"
```

- The body ends with the dedup key, exactly: `Source: review of #<pr>, <thread url>`. That URL is what a later search finds.
- Title and body are about the work itself: nobody outside this session knows which thread this was. Name the platform and the function node, since neither is obvious from a thread link.
- One issue per thread. A refused create is retried as the *same* create once what it named is fixed, never worked around with a second issue.

Then reply with the number (`#141`), not with a plan to open one. If the create fails twice, say so on the thread and leave it open: an unfiled issue with a reply promising one is the state this exists to prevent.

## After posting

Re-request each reviewer whose every thread is addressed, without asking: `gh pr edit <n> --repo ScientaNL/DoctrineJsonFunctions --add-reviewer <login>`.

- Per reviewer, not per PR: one reviewer's five handled while another's two are open re-requests the first alone.
- Addressed: applied, or replied to with a posted reply. An unposted draft is not addressed.
- Report who was skipped and which thread holds each one back.

Resolving the threads stays an offer, it's the reviewer's button.

CI still red or the branch behind `master` → hand off to [/green](green.md).
