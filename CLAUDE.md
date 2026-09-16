# DoctrineJsonFunctions

A library adding JSON query functions to Doctrine ORM's DQL, for MySQL, MariaDB, PostgreSQL, SQLite and SQL Server. Domain terms are in [CONTEXT.md](CONTEXT.md); read it before naming anything.

Published as `scienta/doctrine-json-functions`. Every commit message, PR description and issue reply is public and read by contributors with no context from this session.

## Running commands

Everything runs through composer scripts; there is no task runner.

| Purpose | Command |
|---|---|
| Coding standard | `composer phpcs` |
| Static analysis | `composer phpstan`, `composer psalm` |
| Unit tests | `composer test:unit` |
| Integration tests | `composer test:integration` (or `:mysql`, `:mariadb`, `:postgres`, `:sqlite`, `:mssql`) |

Integration suites need the servers in `docker-compose.yml`; start them before running one.

- **Always ask before opening a PR**, and before posting anything to the upstream tracker.
- **Push branches to `origin` (the fork), never to `upstream`.** The PR base is `ScientaNL/DoctrineJsonFunctions` `master`.
- File writes go through Write/Edit, never `sed -i`, a heredoc or a redirect.

## After making changes

Validate at natural completion points, not after every file.

| Changed | Run |
|---|---|
| Markdown, docs, CI yaml | nothing |
| Any PHP | `composer phpcs`, then `composer phpstan` and `composer psalm` once per change set, never per file |
| A function node or the parser | the above, plus `composer test:unit` |
| A platform-specific node | the above, plus that platform's integration suite |
| `DBALCompatibility`, or anything version-branching | the above, plus the full integration run |

Nothing means nothing: don't fall through to a heavier check because the change felt risky.

## The support matrix decides most questions

PHP 8.1 to 8.5, DBAL 3 and 4, ORM 2.19 and 3, five platforms. Before using an API, confirm it exists in the **lowest** supported major of that package, not the installed one. Version branching belongs in `DBALCompatibility`, never inline in a node. A language feature above PHP 8.1 needs `symfony/polyfill-php83` to cover it, or it doesn't go in.

## Verify; don't assume

- Negative-existence claims ("no node for X", "nothing does Y", "net-new"): search *before* stating them, untruncated. Positive-precedent claims are the twin: cite only code you've read; a file name or a directory listing is not precedent.
- Repo and CI state is a claim too: prove it with the command (`git log`, `git status`, `gh run view`). Session memory of "what I did" isn't authoritative.
- Verification genuinely impossible → take the sensible default, flag it in one line, move on. No hedge, no block.
- Judge placement, name and pattern against pre-existing code, never against code you or this branch just added.
- Naming (no name dictated): follow the surrounding convention. Unclear or conflicting → offer options drawn from similar code, user chooses. Never present an invented name as the obvious one.

## Improve what you touch

A request may be a fixed spec or a rough thought: pressure-test the framing, not just the code, and flag a genuinely better approach even when the current one works.

- **Notice and surface: always**, even when the call is "leave it".
- **Act: cost-gated.** Cheap *and* in scope → do it, say you did. Larger → surface an explicit decision: do-now-with-approval, follow-up issue, or leave-with-reasoning. Never a silent refactor, never a silent drop.
- **"Pre-existing" is no reason to skip a cheap fix in code you are already rewriting**; declining needs a stated reason.
- **Follow-up issues stay pending** until the user decides; never auto-create.

Still a focused change by default. Don't add machinery for complexity that isn't there yet.

## Changing shared code: account for every caller

A change to `AbstractJsonFunctionNode`, `AbstractJsonOperatorFunctionNode`, a platform base node or `DBALCompatibility` reaches every node that extends it. The change is complete only when those are enumerated, confirmed correct, and the behaviour you reasoned about is pinned with a test.

## Sweep the other side of every change

A change is finished when its counterpart is swept, not when the thing you set out to touch works.

- **Removing** something → what existed only to serve it? A now-unused constant, a test double, a README row, a psalm handler.
- **Adding** something → what already exists that this duplicates? A base node that already parses those arguments, a test helper for the setup you are about to hand-roll.

A new function node has four counterparts: the unit test, the integration test, the README table, and the platform base node it should extend.

## Renaming anything

A rename is complete only when every reference is updated in the same edit: class names, `FUNCTION_NAME` values, README tables and examples, test names, cross-links. A `FUNCTION_NAME` change is a **breaking change** for consumers, since it is the string they registered.

## Scope config by pattern, not by listing files

"Everything in area X" → a directory or glob, never a hand-maintained filename list. Covers `phpcs.xml.dist`, `phpstan.neon.dist` paths, `psalm.xml` handlers, `phpunit.xml.dist` suites and CI path filters. Explicit lists only when the intent is "these specific items".

## Writing style

Say the outcome and stop. Mechanism, evidence, counts and tool names are opt-in, not the default; cut anything that would not change the reader's next action. Plain words, active voice, no em dashes. Full register and the AI tells to avoid: [.claude/skills/writing/SKILL.md](.claude/skills/writing/SKILL.md).

There are two registers, human-facing and a terser Claude-facing one. That skill holds which destinations take each; don't mix them.

## Rules and skills

`.claude/rules/` holds the conventions; read the one matching what you touch.

| Touching | Read |
|---|---|
| Any PHP | [php-quality.md](.claude/rules/php-quality.md): promotion, enums vs constants, array types, docblocks |
| Any code | [code-quality.md](.claude/rules/code-quality.md): suppression policy, self-review checklist, comment routing |
| `tests/` | [testing.md](.claude/rules/testing.md): behaviour over implementation, breaking the branch to prove the test |

Skills: [php-type-errors](.claude/skills/php-type-errors/SKILL.md) when PHPStan or Psalm reports a type error, [bugfix](.claude/skills/bugfix/SKILL.md) when fixing reported behaviour, [review-standards](.claude/skills/review-standards/SKILL.md) when reviewing a diff, [writing](.claude/skills/writing/SKILL.md) for human-facing text. Commands: `/fix-phpstan`, `/psalm`, `/clean-code` for the code itself; `/pr` to commit and open a prefilled PR form, `/green` to rebase a PR and fix its red checks, `/resolve` to work through its review threads.

## Agent skills

### Issue tracker

GitHub issues on the upstream repo `ScientaNL/DoctrineJsonFunctions`, via the `gh` CLI with an explicit `--repo`. See `docs/agents/issue-tracker.md`.

### Domain docs

Single-context: one `CONTEXT.md` and `docs/adr/` at the repo root. See `docs/agents/domain.md`.
