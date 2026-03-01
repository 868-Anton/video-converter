Run `herd link` for the current project directory.

Use this command whenever:
- a new Laravel application is created, or
- a project is moved into a deeper subfolder under Herd and no longer appears in the Herd app.

Steps:
1. Confirm the current working directory is the Laravel project root.
2. Run `herd link`.
3. If needed, also run `herd link` from the immediate parent folder that contains multiple projects so Herd can discover nested apps.
4. Report the linked URL/domain from the command output and confirm success.

If `herd` is not available, explain the error and suggest opening Herd or ensuring Herd CLI is installed and on PATH.