'use strict';

module.exports = async ({ github, context, require }) => {
    const fs = require('fs');

    const current    = parseFloat(fs.readFileSync('pct.txt', 'utf8').trim());
    const intExists  = fs.existsSync('pct-integration.txt');
    const currentInt = intExists ? parseFloat(fs.readFileSync('pct-integration.txt', 'utf8').trim()) : null;
    const prNumber   = parseInt(fs.readFileSync('pr-number.txt', 'utf8').trim(), 10);
    const baseRef    = fs.readFileSync('base-ref.txt', 'utf8').trim();

    async function fetchBaseline(filename) {
        const url = `https://raw.githubusercontent.com/${context.repo.owner}/${context.repo.repo}/badges/${filename}`;
        try {
            const resp = await fetch(url);
            if (resp.ok) return { value: parseFloat(await resp.text()), found: true };
        } catch (_) {}
        return { value: 0, found: false };
    }

    const [baselineUnit, baselineInt] = await Promise.all([
        fetchBaseline('coverage.txt'),
        fetchBaseline('coverage-integration.txt'),
    ]);

    function formatRow(label, current, baseline) {
        if (current === null) {
            return { row: `| ${label} | ⚠️ failed | n/a |`, ok: false };
        }
        const delta    = current - baseline.value;
        const sign     = delta >= 0 ? '+' : '';
        const deltaStr = baseline.found ? `${sign}${delta.toFixed(1)}%` : 'n/a';
        const ok       = !baseline.found || current >= baseline.value - 1.0;
        return { row: `| ${label} | **${current}%** | ${deltaStr} ${ok ? '✅' : '❌'} |`, ok };
    }

    const unit = formatRow('Unit',        current,    baselineUnit);
    const intg = formatRow('Integration', currentInt, baselineInt);

    const warnings = [];
    if (!unit.ok && current !== null) warnings.push(`> ⚠️ Unit coverage dropped from ${baselineUnit.value}% to ${current}%. Please add tests.`);
    if (!intg.ok && currentInt !== null) warnings.push(`> ⚠️ Integration coverage dropped from ${baselineInt.value}% to ${currentInt}%. Please add tests.`);
    if (currentInt === null) warnings.push(`> ⚠️ Integration coverage job failed — no coverage data available.`);

    const body = [
        '<!-- coverage-report -->',
        '## Coverage Report',
        '',
        `| Suite | Coverage | Change vs \`${baseRef}\` |`,
        '|---|---|---|',
        unit.row,
        intg.row,
        '',
        ...warnings,
    ].join('\n').trimEnd();

    const marker = '<!-- coverage-report -->';
    const { data: comments } = await github.rest.issues.listComments({
        ...context.repo,
        issue_number: prNumber,
    });
    const existing = comments.find(c => c.body.startsWith(marker));
    if (existing) {
        await github.rest.issues.updateComment({
            ...context.repo,
            comment_id: existing.id,
            body,
        });
    } else {
        await github.rest.issues.createComment({
            ...context.repo,
            issue_number: prNumber,
            body,
        });
    }
};
