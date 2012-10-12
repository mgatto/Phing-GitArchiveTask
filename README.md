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
