#!/usr/bin/env bash
# Builder/auditor loop for CheynTech. Run from the repo root in Git Bash, WSL, or macOS/Linux.
# Needs: agy (logged in), gh (logged in), php, a local TEST MySQL, config/database.php -> TEST db.
# Models: set BUILDER_MODEL / AUDITOR_MODEL to names shown by `agy` (lighter builder, stronger auditor).
set -u
MAX=${MAX:-6}
BUILDER_MODEL=${BUILDER_MODEL:-}
AUDITOR_MODEL=${AUDITOR_MODEL:-}
BRANCH="agent/$(date +%m%d-%H%M)"

[ -n "$(git status --porcelain)" ] && { echo "Commit or stash your changes first."; exit 1; }
git checkout dev && git pull origin dev && git checkout -b "$BRANCH" || exit 1

run_agy() { # model, prompt
  if [ -n "$1" ]; then agy --dangerously-skip-permissions --model "$1" -p "$2"; else agy --dangerously-skip-permissions -p "$2"; fi
}
checks() { bash tests/smoke.sh > LAST_ERRORS.txt 2>&1; bash tests/requirements.sh > REQUIREMENTS.txt 2>&1; }

for i in $(seq 1 "$MAX"); do
  echo "=== iteration $i/$MAX ==="

  run_agy "$BUILDER_MODEL" "You are the BUILDER. Follow AGENTS.md exactly. Read TASK.md, AUDIT.md, LAST_ERRORS.txt and REQUIREMENTS.txt if they exist. \
First apply every numbered finding in AUDIT.md, one at a time, exactly as written. If AUDIT.md does not exist, do the first unchecked TASK.md item only and tick it. \
Touch only the files named. Run the item's 'Done when' check. If an instruction does not match the code, write it in BUILDER_NOTES.md and stop. \
Write two lines in STATUS.md: what changed, what you verified."

  if ! checks; then
    tail -20 LAST_ERRORS.txt | md5sum > .err_now
    if [ -f .err_prev ] && cmp -s .err_now .err_prev; then echo "Same failure twice. Stopping for human. See LAST_ERRORS.txt"; exit 1; fi
    mv .err_now .err_prev
    continue
  fi
  rm -f .err_prev

  git diff dev > CHANGES.diff
  run_agy "$AUDITOR_MODEL" "You are the AUDITOR. Follow AGENTS.md. Modify NO files except AUDIT.md. \
Review CHANGES.diff and the code it touches against the TASK.md item being worked on. Check: SQL injection, missing output escaping, \
leaked secrets or exception text, auth/CSRF gaps, race conditions, missing validation, anything ticked but not truly working. \
Report only medium severity or higher. Write AUDIT.md as a numbered list of ATOMIC instructions for a less capable builder. \
Each one must contain: file and function, the exact change, what NOT to touch, and a command that proves it is done. One finding per change, independent of each other. \
Do not write full diffs. End with exactly 'VERDICT: PASS' or 'VERDICT: FAIL'."

  if grep -q "VERDICT: PASS" AUDIT.md; then
    git add -A
    git commit -m "agent: audited pass (iter $i)"
    git push -u origin "$BRANCH" && gh pr create --base dev --fill --body-file STATUS.md
    echo "PR opened against dev. Your turn to review."; exit 0
  fi
done
echo "Hit iteration cap without a pass. Read AUDIT.md, BUILDER_NOTES.md, LAST_ERRORS.txt."
exit 1
