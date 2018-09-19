如果当前链接被包含在别人的网站中
===========

```[javascript]

    if(top != self){
        top.location = self.location .
    }
```

注意self所指

有用片段：
~~~[javascript]

    var el = document.getElementById('ifrm');
    el.src = url; // assign url to src property
    
    window.frames['ifrm'].location = url;
    
    window.frames['ifrm'].location.replace(url);
    
    // Links in and to Iframed Documents
    <a href="page.html" target="_parent">link</a>
~~~

看这个描述 http://www.dyn-web.com/tutorials/iframes/hidden/demo.php：
通过隐藏 iframe 作为中介  <a target="{hiddenIframeId}">someLinkText</a>
                          <iframe  name="hiddenIframeId"></iframe>
                          <div id="result">
                          这里会同步iframe的内容的  通过在隐藏iframe上注册onload事件！将其内容拷贝到
                          这里就好啦！</div>
~~~
    
            
        Instructions in Brief
        
        Include both an iframe and a display div in your markup as the following demonstrates:
        
        <div id="display"></div>
        
        <iframe id="buffer" name="buffer" src="intro.html"
          onload="dw_Loader.display()"></iframe>
        
        For accessibility, iframe styles can be written using JavaScript, and target attributes can be included in the links:
        
        <a href="yourpage.html" target="buffer">link</a>
        
        Include a script tag for the small external JavaScript file, dw_loader.js. That file includes the following settings and options:
        
        loadMsg: 'Retrieving data ...',
        displayID: 'display', // default id for display div
        iframeID: 'buffer', // default id for hidden iframe
        bReplace: false, // to use location.replace (no history support)
        bScrollToTop: false, // page scroll to top when new content is loaded?
        
        Here is an example link with the onclick attribute and optional parameters:
        
        <a href="yourpage.html" target="buffer"
          onclick="return dw_Loader.load(this.href, 
            'ifrm', // iframe id
            'ifrmDiv', // id of div where iframe contents displayed
            ifrmCallback // function to call after contents transferred to div
            )">link</a>
        
        A demo is included in the download file. The code has been tested successfully on Firefox, Chrome, Internet Explorer 5.5+, Opera and Safari.


~~~

## window 跟document

~~~
   var iframe = document.getElementById('your-iframe-id');
   
   From jQuery's source code:
   
   var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
    
    var iframeContent;
    
    if (iframeDocument) {
        iframeContent = iframeDocument.getElementById('frameBody');
    
        // or
        iframeContent = iframeDocument.querySelectorAll('#frameBody');
    }
    
    
    Get just the window element from iframe to call some global function, e.g. jQuery:
    
    var iframeWindow = iframe.contentWindow
    
    if (iframeWindow) {
        // you can even call jQuery or other frameworks if it is loaded in the iframe
        iframeContent = iframeWindow.jQuery('#frameBody');
    
        // or
        iframeContent = iframeWindow.$('#frameBody');
    }
    
    
    function getFrameContents(){
       var iFrame =  document.getElementById('id_description_iframe');
       var iFrameBody;
       if ( iFrame.contentDocument ) 
       { // FF
         iFrameBody = iFrame.contentDocument.getElementsByTagName('body')[0];
       }
       else if ( iFrame.contentWindow ) 
       { // IE
         iFrameBody = iFrame.contentWindow.document.getElementsByTagName('body')[0];
       }
        alert(iFrameBody.innerHTML);
     }
    
~~~