/**
 * Created by yiqing on 2015/2/9.
 */
function fileUpload(form, action_url, div_id) {
    var iframe = document.createElement("iframe");
    iframe.setAttribute("id", "upload_iframe");
    iframe.setAttribute("name", "upload_iframe");
    iframe.setAttribute("width", "0");
    iframe.setAttribute("height", "0");
    iframe.setAttribute("border", "0");
    iframe.setAttribute("style", "width: 0; height: 0; border: none;");
    form.parentNode.appendChild(iframe);
    window.frames['upload_iframe'].name = "upload_iframe";
    iframeId = document.getElementById("upload_iframe");
    var eventHandler = function () {
        if (iframeId.detachEvent)
            iframeId.detachEvent("onload", eventHandler);
        else
            iframeId.removeEventListener("load", eventHandler, false);
        if (iframeId.contentDocument) {
            content = iframeId.contentDocument.body.innerHTML;
        } else if (iframeId.contentWindow) {
            content = iframeId.contentWindow.document.body.innerHTML;
        } else if (iframeId.document) {
            content = iframeId.document.body.innerHTML;
        }
        document.getElementById(div_id).innerHTML = content;
        setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
    }
    if (iframeId.addEventListener)iframeId.addEventListener("load", eventHandler, true);
    if (iframeId.attachEvent)iframeId.attachEvent("onload", eventHandler);
    form.setAttribute("target", "upload_iframe");
    form.setAttribute("action", action_url);
    form.setAttribute("method", "post");
    form.setAttribute("enctype", "multipart/form-data");
    form.setAttribute("encoding", "multipart/form-data");
    form.submit();
    document.getElementById(div_id).innerHTML = "Uploading...";
}