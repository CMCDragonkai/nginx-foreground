Unfortunately you need to use:

`nginx -p . -c ./nginx.conf`.

We move that into a `nginx-fg` function:

```
nginx-fg () {

    config_directory="$(dirname "$1")"
    config_file="$(basename "$1")"

    nginx \
        -p "$config_directory" \
        -c "$config_file"

}
```

If we could make `./nginx.conf.php` an executable that passes its directory and its filename in, that would be great. But no multi-parameter support in shebangs, and it would require a self-exec, but a self-exec that skips the first 2 lines or something like that.

Can't make nginx not create a `.nginx.pid`, so I put it into current directory. So make sure to ignore it. Also can't seem to make it unique either, unless there's variable inside nginx that gives us the PID.

Change mimetypes to the relevant mimetypes.

Cannot make `.nginx.pid` be stored in `/run` or `/tmp` or whatever, because it would prevent running multiple NGINX servers at the same time. And foregrounded nginx should be able to do this.
