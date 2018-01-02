//网页刷新或者重新加载后滚动条的位置不变
// http://blog.csdn.net/hr541659660/article/details/53693912
window.onbeforeunload = function () {  
    var scrollPos;  
    if (typeof window.pageYOffset != 'undefined') {  
        scrollPos = window.pageYOffset;  
    }  
    else if (typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') {  
        scrollPos = document.documentElement.scrollTop;  
    }  
    else if (typeof document.body != 'undefined') {  
        scrollPos = document.body.scrollTop;  
    }  
    document.cookie = "scrollTop=" + scrollPos; //存储滚动条位置到cookies中  
}  
  
window.onload = function () {  
    if (document.cookie.match(/scrollTop=([^;]+)(;|$)/) != null) {  
        var arr = document.cookie.match(/scrollTop=([^;]+)(;|$)/); //cookies中不为空，则读取滚动条位置  
        document.documentElement.scrollTop = parseInt(arr[1]);  
        document.body.scrollTop = parseInt(arr[1]);  
    }  
}  
