/**
 * Created by yiqing on 14-9-17.
 */

function url_parameter(url, param, value) {
    // Find given parameter.
    var val = new RegExp('(\\?|\\&)' + param + '=.*?(?=(&|$))'),
        parts = url.toString().split('#'),
        url = parts[0],
        hash = parts[1]
    qstring = /\?.+$/,
        return_url = url;

    // Check for parameter existance: Replace it and determine whether & or ? will be added at the beginning.
    if (val.test(url)) {
        // If value empty and parameter exists, remove the parameter.
        if (!value.length) {
            return_url = url.replace(val, '');
        }
        else {
            return_url = url.replace(val, '$1' + param + '=' + value);
        }
    }
    // If there are query strings add the param to the end of it.
    else if (qstring.test(url)) {
        return_url = url + '&' + param + '=' + value;
    }
    // Add if there are no query strings.
    else {
        return_url = url + '?' + param + '=' + value;
    }

    // Add hash if it exists.
    if (hash) {
        return_url += '#' + hash;
    }

    return return_url;
}