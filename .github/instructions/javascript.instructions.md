---
applyTo: "**/*.js"
---

# JavaScript changes

- Read the surrounding code and identify the existing runtime, module, and formatting conventions before editing.
- Keep changes focused and preserve existing behavior outside the requested change.
- Check package manifests and plugin integrations before changing dependencies or plugin-facing behavior. Do not edit bundled or vendor plugin code unless explicitly requested.
- Do not add a library, plugin, or dependency unless the user asks for it or the change cannot reasonably be made with existing project tools.
- Handle invalid input and asynchronous errors using the project's established patterns; do not silently swallow failures.
- Run the smallest relevant test, lint, or build check available after changes.
