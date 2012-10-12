Phing-GitArchiveTask
====================

The missing GitArchiveTask for Phing, the PHP build system.

Synopsis
--------

```xml
<gitfetch
    repository="${repo.dir.resolved}"
    format="zip"
    output=""
    revision=""
    prefix=""
    path="" />
```

Why
---

It could be better than `git checkout` since we will get a pristine
archive of the sources, without the `.git` directory, or other git-specific files.

Don't foget to have a decent .gitattributes file in your project, too.
Having one will help keep .gitignore and kindred files from polluting your
actual project.

Example .gitattributes file:

```
.gitattributes export-ignore
.gitignore export-ignore
```

Defaults
--------

<table>
    <tr>
        <th>format</th>
        <td>tar.gz</td>
    </tr>
    <tr>
        <th>output</th>
        <td>. (current working directory)</td>
    </tr>
    <tr>
        <th>revision</th>
        <td>HEAD</td>
    </tr>
    <tr>
        <th>prefix</th>
        <td>None</td>
    </tr>
    <tr>
        <th>path</th>
        <td>empty array (i.e. Nothing)</td>
    </tr>
</table>
