---
applyTo: "**/*"
---

# Git workflow

- Use the existing `main` branch by default. Do not create or switch to another branch unless the user explicitly asks for a new branch.
- After completing and validating requested project changes, commit only those changes to `main` and push to the configured `origin`, unless the user explicitly says otherwise.
- Never force-push or amend existing commits. If the remote has advanced or a conflict prevents a safe push, stop and explain the issue.
